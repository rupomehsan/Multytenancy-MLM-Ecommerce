<?php

namespace App\Modules\MLM\Managements\Dashboard\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\MLM\Managements\Commissions\Database\Models\MlmCommission;
use App\Modules\MLM\Managements\Commissions\Database\Models\CommissionLog;
use App\Modules\MLM\Managements\Wallet\Database\Models\WalletTransaction;
use App\Modules\MLM\Managements\Withdrow\Database\Models\WithdrawalRequest;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('MLM/Managements/Dashboard');
    }

    public function dashboard()
    {
        // Key Statistics
        $stats = $this->getKeyStatistics();

        // Level-wise referral counts
        $levelStats = $this->getLevelWiseReferrals();

        // Top earners
        $topEarners = $this->getTopEarners();

        // Recent commission activities
        $recentActivities = $this->getRecentCommissionActivities();

        // Monthly commission trends (last 12 months)
        $monthlyTrends = $this->getMonthlyCommissionTrends();

        // Level-wise commission breakdown
        $levelCommissions = $this->getLevelCommissionBreakdown();

        // Commission status distribution
        $statusDistribution = $this->getCommissionStatusDistribution();

        // Recent withdrawal requests
        $recentWithdrawals = $this->getRecentWithdrawals();

        return view('dashboard', compact(
            'stats',
            'levelStats',
            'topEarners',
            'recentActivities',
            'monthlyTrends',
            'levelCommissions',
            'statusDistribution',
            'recentWithdrawals'
        ));
    }

    /**
     * Get key dashboard statistics
     */
    private function getKeyStatistics()
    {
        return [
            'total_users' => User::count(),
            'total_referrals' => User::whereNotNull('referred_by')->count(),
            'total_commissions' => MlmCommission::sum('commission_amount'),
            'approved_commissions' => MlmCommission::where('status', MlmCommission::STATUS_APPROVED)->sum('commission_amount'),
            'pending_commissions' => MlmCommission::where('status', MlmCommission::STATUS_PENDING)->sum('commission_amount'),
            'total_withdrawals' => WithdrawalRequest::where('status', 'approved')->sum('amount'),
            'pending_withdrawals' => WithdrawalRequest::where('status', 'pending')->sum('amount'),
            'pending_withdrawal_count' => WithdrawalRequest::where('status', 'pending')->count(),
            'total_wallet_transactions' => WalletTransaction::sum('amount'),
            'active_referrers' => MlmCommission::distinct('referrer_id')->count('referrer_id'),
        ];
    }

    /**
     * Get level-wise referral statistics
     */
    private function getLevelWiseReferrals()
    {
        return [
            'level1' => MlmCommission::where('level', 1)->distinct('buyer_id')->count('buyer_id'),
            'level2' => MlmCommission::where('level', 2)->distinct('buyer_id')->count('buyer_id'),
            'level3' => MlmCommission::where('level', 3)->distinct('buyer_id')->count('buyer_id'),
        ];
    }

    /**
     * Get top earners with their commission details
     */
    private function getTopEarners()
    {
        return User::select('users.*')
            ->selectRaw('COALESCE(SUM(mlm_commissions.commission_amount), 0) as total_earned')
            ->selectRaw('COUNT(CASE WHEN mlm_commissions.level = 1 THEN 1 END) as level1_count')
            ->selectRaw('COUNT(CASE WHEN mlm_commissions.level = 2 THEN 1 END) as level2_count')
            ->selectRaw('COUNT(CASE WHEN mlm_commissions.level = 3 THEN 1 END) as level3_count')
            ->leftJoin('mlm_commissions', 'users.id', '=', 'mlm_commissions.referrer_id')
            ->groupBy('users.id', 'users.name', 'users.email', 'users.phone', 'users.wallet_balance', 'users.referred_by', 'users.created_at', 'users.updated_at')
            ->having('total_earned', '>', 0)
            ->orderByDesc('total_earned')
            ->limit(10)
            ->get();
    }

    /**
     * Get recent commission activities
     */
    private function getRecentCommissionActivities()
    {
        return CommissionLog::with(['referrer', 'order'])
            ->select('mlm_commission_logs.*')
            ->orderByDesc('created_at')
            ->limit(15)
            ->get()
            ->map(function ($log) {
                return [
                    'user_name' => $log->referrer->name ?? 'N/A',
                    'level' => $log->metadata['level'] ?? 'N/A',
                    'commission_amount' => number_format($log->amount, 2),
                    'activity_type' => ucfirst($log->activity_type),
                    'status' => $log->new_status ?? $log->old_status,
                    'created_at' => $log->created_at,
                ];
            });
    }

    /**
     * Get monthly commission trends for last 12 months
     */
    private function getMonthlyCommissionTrends()
    {
        $trends = MlmCommission::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(commission_amount) as total'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'labels' => $trends->pluck('month')->map(fn($m) => Carbon::parse($m)->format('M Y'))->toArray(),
            'data' => $trends->pluck('total')->toArray(),
            'counts' => $trends->pluck('count')->toArray(),
        ];
    }

    /**
     * Get commission breakdown by level
     */
    private function getLevelCommissionBreakdown()
    {
        return MlmCommission::select('level')
            ->selectRaw('SUM(commission_amount) as total')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('level')
            ->orderBy('level')
            ->get()
            ->map(function ($item) {
                return [
                    'level' => 'Level ' . $item->level,
                    'total' => $item->total,
                    'count' => $item->count,
                ];
            });
    }

    /**
     * Get commission status distribution
     */
    private function getCommissionStatusDistribution()
    {
        return MlmCommission::select('status')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('SUM(commission_amount) as total')
            ->groupBy('status')
            ->get()
            ->map(function ($item) {
                return [
                    'status' => ucfirst($item->status),
                    'count' => $item->count,
                    'total' => $item->total,
                ];
            });
    }

    /**
     * Get recent withdrawal requests
     */
    private function getRecentWithdrawals()
    {
        return WithdrawalRequest::with('user')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function ($withdrawal) {
                return [
                    'user_name' => $withdrawal->user->name ?? 'N/A',
                    'amount' => number_format($withdrawal->amount, 2),
                    'status' => ucfirst($withdrawal->status),
                    'payment_method' => $withdrawal->payment_method,
                    'created_at' => $withdrawal->created_at,
                ];
            });
    }
}
