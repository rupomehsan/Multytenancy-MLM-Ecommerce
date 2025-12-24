<?php

namespace App\Http\Controllers\Tenant\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Http;
use App\Mail\UserVerificationMail;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Modules\MLM\Service\ReferralTreeService;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Http\Controllers\Controller;
use App\Modules\MLM\Managements\Commissions\Database\Models\MlmCommission;

class MlmController extends Controller
{
    protected $baseRoute = 'tenant.frontend.pages.customer_panel.pages.mlm.';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Display the customer's referral tree.
     * Shows hierarchical tree structure up to 3 levels deep.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function referral_tree()
    {
        // Get the authenticated customer (middleware already ensures auth)
        $customer = auth('customer')->user();

        // Initialize the ReferralTreeService
        $treeService = new ReferralTreeService();

        // Build the tree structure (max 3 levels)
        $tree = $treeService->buildTree($customer);

        // Get additional network statistics
        $stats = $treeService->getNetworkStats($customer);

        // Pass data to the view
        return view($this->baseRoute . 'referral_tree', [
            'tree' => $tree,
            'stats' => $stats,
            'rootCustomer' => $customer,
        ]);
    }

    /**
     * Display the customer's referral list with levels and statistics.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function referral_list()
    {
        $customer = auth('customer')->user();

        // Initialize the ReferralTreeService
        $treeService = new ReferralTreeService();

        // Build the full tree
        $tree = $treeService->buildTree($customer);

        // Flatten the tree for table display
        $referralsList = $treeService->flattenTree($tree);

        // Remove the root node (customer themselves)
        $referralsList = array_filter($referralsList, function ($node) use ($customer) {
            return $node['id'] != $customer->id;
        });

        // Get network statistics
        $stats = $treeService->getNetworkStats($customer);

        // Pass data to the view
        return view($this->baseRoute . 'referral_lists', [
            'referrals' => $referralsList,
            'stats' => $stats,
            'totalReferrals' => count($referralsList),
        ]);
    }

    /**
     * Show detailed view of a specific referral and their network.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function referral_details($id)
    {
        $customer = auth('customer')->user();

        // Find the referral user
        $referral = User::where('id', $id)
            ->where('user_type', 3)
            ->firstOrFail();

        // Check if this referral belongs to customer's network
        $treeService = new ReferralTreeService();
        $customerTree = $treeService->buildTree($customer);
        $flatTree = $treeService->flattenTree($customerTree);

        // Verify the referral is in customer's network
        $isInNetwork = collect($flatTree)->contains('id', $id);

        if (!$isInNetwork) {
            Toastr::error('This user is not in your referral network', 'Access Denied');
            return redirect()->back();
        }

        // Build the referral's own tree
        $referralTree = $treeService->buildTree($referral);

        // Get referral's network statistics
        $referralStats = $treeService->getNetworkStats($referral);

        // Get referral's parent (who referred them)
        $parent = $referral->parent;

        // Get direct referrals list
        $directReferrals = User::where('referred_by', $referral->id)
            ->where('user_type', 3)
            ->where('status', 1)
            ->select('id', 'name', 'email', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        // Pass data to the view
        return view($this->baseRoute . 'referral_details', [
            'referral' => $referral,
            'tree' => $referralTree,
            'stats' => $referralStats,
            'parent' => $parent,
            'directReferrals' => $directReferrals,
        ]);
    }

    /**
     * Show the commission history page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function commission_history(Request $request)
    {
        $customer = auth('customer')->user();

        // Build query for commissions
        $query = DB::table('mlm_commissions as mc')
            ->leftJoin('orders as o', 'mc.order_id', '=', 'o.id')
            ->leftJoin('users as buyer', 'mc.buyer_id', '=', 'buyer.id')
            ->select(
                'mc.id',
                'mc.order_id',
                'mc.level',
                'mc.commission_amount',
                'mc.status',
                'mc.percentage_used',
                'mc.created_at',
                'o.order_no',
                'o.slug as order_slug',
                'buyer.name as buyer_name',
                'buyer.email as buyer_email'
            )
            ->where('mc.referrer_id', $customer->id)
            ->whereNull('mc.deleted_at');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('mc.status', $request->status);
        }

        if ($request->filled('level')) {
            $query->where('mc.level', $request->level);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('mc.created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('mc.created_at', '<=', $request->date_to);
        }

        // Get paginated results
        $commissions = $query->orderBy('mc.created_at', 'desc')->paginate(25);

        // Get commission summary for the logged-in customer
        $totalEarned = MlmCommission::where('referrer_id', $customer->id)
            ->whereIn('status', ['approved', 'paid'])
            ->sum('commission_amount');

        $pending = MlmCommission::where('referrer_id', $customer->id)
            ->where('status', 'pending')
            ->sum('commission_amount');

        $pendingCount = MlmCommission::where('referrer_id', $customer->id)
            ->where('status', 'pending')
            ->count();

        // Available balance from user's wallet
        $availableBalance = $customer->wallet_balance ?? 0;

        return view($this->baseRoute . 'commision_records', [
            'commissions' => $commissions,
            'totalEarned' => $totalEarned,
            'pending' => $pending,
            'pendingCount' => $pendingCount,
            'availableBalance' => $availableBalance,
        ]);
    }

    /**
     * Show the earning reports page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function earning_reports(Request $request)
    {
        $customer = auth('customer')->user();

        // Get total earnings stats
        $totalEarnings = DB::table('mlm_commissions')
            ->where('referrer_id', $customer->id)
            ->whereNull('deleted_at')
            ->sum('commission_amount');

        $thisMonthEarnings = DB::table('mlm_commissions')
            ->where('referrer_id', $customer->id)
            ->whereNull('deleted_at')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->sum('commission_amount');

        // Get last 6 months average
        $lastSixMonthsAvg = DB::table('mlm_commissions')
            ->where('referrer_id', $customer->id)
            ->whereNull('deleted_at')
            ->where('created_at', '>=', now()->subMonths(6))
            ->avg('commission_amount') ?? 0;

        $lifetimeEarnings = $totalEarnings;

        // Monthly earnings for last 6 months
        $monthlyEarnings = [];
        $monthLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabels[] = $date->format('M');
            $earnings = DB::table('mlm_commissions')
                ->where('referrer_id', $customer->id)
                ->whereNull('deleted_at')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('commission_amount');
            $monthlyEarnings[] = $earnings ?? 0;
        }

        // Daily earnings for current month
        $dailyEarnings = [];
        $dailyLabels = [];
        $daysInMonth = now()->daysInMonth;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            if ($day % 2 != 0) { // Only odd days for cleaner chart
                $dailyLabels[] = $day;
                $earnings = DB::table('mlm_commissions')
                    ->where('referrer_id', $customer->id)
                    ->whereNull('deleted_at')
                    ->whereYear('created_at', now()->year)
                    ->whereMonth('created_at', now()->month)
                    ->whereDay('created_at', $day)
                    ->sum('commission_amount');
                $dailyEarnings[] = $earnings ?? 0;
            }
        }

        // Earnings by type (level)
        $earningsByLevel = DB::table('mlm_commissions')
            ->select('level', DB::raw('SUM(commission_amount) as total'))
            ->where('referrer_id', $customer->id)
            ->whereNull('deleted_at')
            ->groupBy('level')
            ->get();

        $totalByLevel = $earningsByLevel->sum('total');
        $earningsBreakdown = [];
        foreach ($earningsByLevel as $item) {
            $percentage = $totalByLevel > 0 ? round(($item->total / $totalByLevel) * 100, 1) : 0;
            $earningsBreakdown[] = [
                'level' => $item->level,
                'amount' => $item->total,
                'percentage' => $percentage
            ];
        }

        // Top contributors (referrals that generated most commission)
        $topContributors = DB::table('mlm_commissions as mc')
            ->leftJoin('users as buyer', 'mc.buyer_id', '=', 'buyer.id')
            ->select('buyer.name', 'buyer.email', DB::raw('SUM(mc.commission_amount) as total'))
            ->where('mc.referrer_id', $customer->id)
            ->whereNull('mc.deleted_at')
            ->whereNotNull('buyer.id')
            ->groupBy('buyer.id', 'buyer.name', 'buyer.email')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Growth metrics
        $lastMonthEarnings = DB::table('mlm_commissions')
            ->where('referrer_id', $customer->id)
            ->whereNull('deleted_at')
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('commission_amount') ?? 1;

        $monthOverMonth = $lastMonthEarnings > 0
            ? round((($thisMonthEarnings - $lastMonthEarnings) / $lastMonthEarnings) * 100, 1)
            : 0;

        // Quarter growth
        $lastQuarterEarnings = DB::table('mlm_commissions')
            ->where('referrer_id', $customer->id)
            ->whereNull('deleted_at')
            ->where('created_at', '>=', now()->subMonths(6))
            ->where('created_at', '<', now()->subMonths(3))
            ->sum('commission_amount') ?? 1;

        $thisQuarterEarnings = DB::table('mlm_commissions')
            ->where('referrer_id', $customer->id)
            ->whereNull('deleted_at')
            ->where('created_at', '>=', now()->subMonths(3))
            ->sum('commission_amount') ?? 0;

        $quarterGrowth = $lastQuarterEarnings > 0
            ? round((($thisQuarterEarnings - $lastQuarterEarnings) / $lastQuarterEarnings) * 100, 1)
            : 0;

        // Yearly growth
        $lastYearEarnings = DB::table('mlm_commissions')
            ->where('referrer_id', $customer->id)
            ->whereNull('deleted_at')
            ->whereYear('created_at', now()->subYear()->year)
            ->sum('commission_amount') ?? 1;

        $thisYearEarnings = DB::table('mlm_commissions')
            ->where('referrer_id', $customer->id)
            ->whereNull('deleted_at')
            ->whereYear('created_at', now()->year)
            ->sum('commission_amount') ?? 0;

        $yearlyGrowth = $lastYearEarnings > 0
            ? round((($thisYearEarnings - $lastYearEarnings) / $lastYearEarnings) * 100, 1)
            : 0;

        // Average daily earnings
        $totalDays = DB::table('mlm_commissions')
            ->where('referrer_id', $customer->id)
            ->whereNull('deleted_at')
            ->selectRaw('COUNT(DISTINCT DATE(created_at)) as days')
            ->value('days') ?? 1;

        $avgDaily = $totalDays > 0 ? round($totalEarnings / $totalDays, 2) : 0;

        return view($this->baseRoute . 'earning_reports', [
            'totalEarnings' => $totalEarnings,
            'thisMonthEarnings' => $thisMonthEarnings,
            'lastSixMonthsAvg' => $lastSixMonthsAvg,
            'lifetimeEarnings' => $lifetimeEarnings,
            'monthlyEarnings' => $monthlyEarnings,
            'monthLabels' => $monthLabels,
            'dailyEarnings' => $dailyEarnings,
            'dailyLabels' => $dailyLabels,
            'earningsBreakdown' => $earningsBreakdown,
            'topContributors' => $topContributors,
            'monthOverMonth' => $monthOverMonth,
            'quarterGrowth' => $quarterGrowth,
            'yearlyGrowth' => $yearlyGrowth,
            'avgDaily' => $avgDaily,
        ]);
    }

    /**
     * Show the withdrawal requests page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function withdrawal_requests(Request $request)
    {
        $customer = auth('customer')->user();

        // Calculate available balance - only count approved/paid commissions
        $totalEarned = DB::table('mlm_commissions')
            ->where('referrer_id', $customer->id)
            ->whereIn('status', ['approved', 'paid'])
            ->whereNull('deleted_at')
            ->sum('commission_amount');

        // Get total withdrawn (completed requests)
        $totalWithdrawn = DB::table('mlm_withdrawal_requests')
            ->where('user_id', $customer->id)
            ->where('status', 'completed')
            ->sum('amount');

        // Get pending withdrawal amount
        $pendingAmount = DB::table('mlm_withdrawal_requests')
            ->where('user_id', $customer->id)
            ->whereIn('status', ['pending', 'processing', 'approved'])
            ->sum('amount');

        $pendingCount = DB::table('mlm_withdrawal_requests')
            ->where('user_id', $customer->id)
            ->whereIn('status', ['pending', 'processing', 'approved'])
            ->count();

        // Get rejected amount
        $rejectedAmount = DB::table('mlm_withdrawal_requests')
            ->where('user_id', $customer->id)
            ->where('status', 'rejected')
            ->sum('amount');

        $rejectedCount = DB::table('mlm_withdrawal_requests')
            ->where('user_id', $customer->id)
            ->where('status', 'rejected')
            ->count();

        // Available balance = total earned - total withdrawn - pending (ensure non-negative)
        $availableBalance = max(0, $totalEarned - $totalWithdrawn - $pendingAmount);

        // Build query for withdrawal requests
        $query = DB::table('mlm_withdrawal_requests')
            ->where('user_id', $customer->id)
            ->select('*');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Paginate results
        $withdrawalRequests = $query->orderBy('created_at', 'desc')->paginate(15);

        return view($this->baseRoute . 'withdrowal', [
            'availableBalance' => $availableBalance,
            'totalEarned' => $totalEarned,
            'pendingAmount' => $pendingAmount,
            'pendingCount' => $pendingCount,
            'totalWithdrawn' => $totalWithdrawn,
            'rejectedAmount' => $rejectedAmount,
            'rejectedCount' => $rejectedCount,
            'withdrawalRequests' => $withdrawalRequests,
        ]);
    }

    /**
     * Submit a new withdrawal request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit_withdrawal_request(Request $request)
    {
        $customer = auth('customer')->user();

        // Calculate available balance
        $totalEarned = DB::table('mlm_commissions')
            ->where('referrer_id', $customer->id)
            ->whereIn('status', ['approved', 'paid'])
            ->whereNull('deleted_at')
            ->sum('commission_amount');

        $totalWithdrawn = DB::table('mlm_withdrawal_requests')
            ->where('user_id', $customer->id)
            ->where('status', 'completed')
            ->sum('amount');

        $pendingAmount = DB::table('mlm_withdrawal_requests')
            ->where('user_id', $customer->id)
            ->whereIn('status', ['pending', 'processing', 'approved'])
            ->sum('amount');

        $availableBalance = max(0, $totalEarned - $totalWithdrawn - $pendingAmount);

        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:500',
                'max:' . $availableBalance
            ],
            'method' => 'required|string',
            'account_number' => 'required|string',
            'account_holder' => 'required|string',
            'notes' => 'nullable|string|max:500'
        ], [
            'amount.max' => 'Insufficient balance. Available: ৳' . number_format($availableBalance, 2),
            'amount.min' => 'Minimum withdrawal amount is ৳500',
        ]);

        // Check available balance again
        if ($request->amount > $availableBalance) {
            Toastr::error('Insufficient balance. Available: ৳' . number_format($availableBalance, 2), 'Error');
            return redirect()->back()->withInput();
        }

        if ($availableBalance < 500) {
            Toastr::error('Minimum withdrawal amount is ৳500. Your available balance is ৳' . number_format($availableBalance, 2), 'Error');
            return redirect()->back();
        }

        // Create withdrawal request
        DB::table('mlm_withdrawal_requests')->insert([
            'user_id' => $customer->id,
            'amount' => $request->amount,
            'payment_method' => $request->method,
            'payment_details' => json_encode([
                'account_number' => $request->account_number,
                'account_holder' => $request->account_holder,
            ]),
            'status' => 'pending',
            'admin_notes' => $request->notes,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // TODO: Send notification to admin
        // TODO: Send confirmation email to user

        Toastr::success('Withdrawal request submitted successfully! We will process it within 24-48 hours.', 'Success');
        return redirect()->back();
    }
}
