<?php

namespace App\Modules\MLM\Managements\TopEarners\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

/**
 * ViewTopEarners Action
 * 
 * Powers the server-side DataTable for MLM top earners.
 * Shows users ranked by total earnings with level-wise breakdown.
 * 
 * Performance: Optimized with subqueries for level calculations, single main query.
 */
class ViewTopEarners
{
    /**
     * Execute DataTable query for top earners.
     * 
     * Query strategy:
     * - Use mlm_user_wallet_balances.total_earned for main ranking
     * - Calculate level-wise earnings from mlm_commissions (paid only)
     * - Include referral network size
     * 
     * @param Request $request
     * @return mixed DataTable JSON response
     */
    public static function execute(Request $request)
    {
        // Subquery for Level 1 earnings
        $level1Earnings = DB::table('mlm_commissions as mc1')
            ->select('mc1.referrer_id', DB::raw('SUM(mc1.commission_amount) as level_1_earnings'))
            ->where('mc1.level', 1)
            ->whereIn('mc1.status', ['approved', 'paid'])
            ->groupBy('mc1.referrer_id');

        // Subquery for Level 2 earnings
        $level2Earnings = DB::table('mlm_commissions as mc2')
            ->select('mc2.referrer_id', DB::raw('SUM(mc2.commission_amount) as level_2_earnings'))
            ->where('mc2.level', 2)
            ->whereIn('mc2.status', ['approved', 'paid'])
            ->groupBy('mc2.referrer_id');

        // Subquery for Level 3 earnings
        $level3Earnings = DB::table('mlm_commissions as mc3')
            ->select('mc3.referrer_id', DB::raw('SUM(mc3.commission_amount) as level_3_earnings'))
            ->where('mc3.level', 3)
            ->whereIn('mc3.status', ['approved', 'paid'])
            ->groupBy('mc3.referrer_id');

        // Subquery for direct referrals count
        $directReferrals = DB::table('users as ref_users')
            ->select('ref_users.referred_by', DB::raw('COUNT(*) as direct_referrals'))
            ->whereNotNull('ref_users.referred_by')
            ->groupBy('ref_users.referred_by');

        // Main query
        $query = DB::table('users as u')
            ->join('mlm_user_wallet_balances as wb', 'u.id', '=', 'wb.user_id')
            ->leftJoinSub($level1Earnings, 'l1', 'u.id', '=', 'l1.referrer_id')
            ->leftJoinSub($level2Earnings, 'l2', 'u.id', '=', 'l2.referrer_id')
            ->leftJoinSub($level3Earnings, 'l3', 'u.id', '=', 'l3.referrer_id')
            ->leftJoinSub($directReferrals, 'dr', 'u.id', '=', 'dr.referred_by')
            ->select(
                'u.id as user_id',
                'u.name',
                'u.email',
                'u.phone',
                'u.created_at as join_date',
                // Wallet balances
                'wb.total_earned',
                'wb.total_withdrawn',
                'wb.total_balance',
                // Level-wise earnings (with COALESCE for users with no commissions)
                DB::raw('COALESCE(l1.level_1_earnings, 0) as level_1_earnings'),
                DB::raw('COALESCE(l2.level_2_earnings, 0) as level_2_earnings'),
                DB::raw('COALESCE(l3.level_3_earnings, 0) as level_3_earnings'),
                // Referral stats
                DB::raw('COALESCE(dr.direct_referrals, 0) as direct_referrals')
            )
            ->where('wb.total_earned', '>', 0) // Only users with earnings
            ->orderByDesc('wb.total_earned');

        return Datatables::of($query)
            // Rank column (auto-incremented)
            ->addColumn('rank', function ($row) {
                static $rank = 0;
                return ++$rank;
            })
            // User info column with badge
            ->addColumn('user_info', function ($row) {
                $badge = '';
                if ($row->total_earned >= 50000) {
                    $badge = '<span class="badge badge-warning ml-2" title="Diamond Earner"><i class="fas fa-gem"></i> Diamond</span>';
                } elseif ($row->total_earned >= 20000) {
                    $badge = '<span class="badge badge-success ml-2" title="Gold Earner"><i class="fas fa-star"></i> Gold</span>';
                } elseif ($row->total_earned >= 10000) {
                    $badge = '<span class="badge badge-primary ml-2" title="Silver Earner"><i class="fas fa-medal"></i> Silver</span>';
                }

                return '<div class="user-info">
                            <div><strong>' . e($row->name) . '</strong>' . $badge . '</div>
                            <div class="text-muted small">' . e($row->email) . '</div>
                            <span class="badge badge-secondary">#' . $row->user_id . '</span>
                        </div>';
            })
            // Total earnings (formatted with color)
            ->addColumn('total_earnings', function ($row) {
                $amount = (float) $row->total_earned;
                return '<div class="text-center">
                            <strong class="text-success" style="font-size: 16px;">' .
                    number_format($amount, 2) . ' BDT</strong>
                        </div>';
            })
            // Level 1 earnings
            ->addColumn('level_1_earn', function ($row) {
                $amount = (float) $row->level_1_earnings;
                if ($amount > 0) {
                    return '<div class="text-center">
                                <span class="badge badge-primary" style="font-size: 12px;">' .
                        number_format($amount, 2) . ' BDT</span>
                            </div>';
                }
                return '<div class="text-center"><span class="text-muted">0.00</span></div>';
            })
            // Level 2 earnings
            ->addColumn('level_2_earn', function ($row) {
                $amount = (float) $row->level_2_earnings;
                if ($amount > 0) {
                    return '<div class="text-center">
                                <span class="badge badge-success" style="font-size: 12px;">' .
                        number_format($amount, 2) . ' BDT</span>
                            </div>';
                }
                return '<div class="text-center"><span class="text-muted">0.00</span></div>';
            })
            // Level 3 earnings
            ->addColumn('level_3_earn', function ($row) {
                $amount = (float) $row->level_3_earnings;
                if ($amount > 0) {
                    return '<div class="text-center">
                                <span class="badge badge-warning" style="font-size: 12px;">' .
                        number_format($amount, 2) . ' BDT</span>
                            </div>';
                }
                return '<div class="text-center"><span class="text-muted">0.00</span></div>';
            })
            // Direct referrals count
            ->addColumn('referrals', function ($row) {
                $count = (int) $row->direct_referrals;
                if ($count > 0) {
                    return '<div class="text-center">
                                <span class="badge badge-info">' . $count . ' Referrals</span>
                            </div>';
                }
                return '<div class="text-center"><span class="text-muted">0</span></div>';
            })
            // Join date
            ->addColumn('join_date', function ($row) {
                return '<div class="text-center">' .
                    date('d M Y', strtotime($row->join_date)) .
                    '</div>';
            })
            // Enable raw HTML rendering
            ->rawColumns([
                'user_info',
                'total_earnings',
                'level_1_earn',
                'level_2_earn',
                'level_3_earn',
                'referrals',
                'join_date'
            ])
            ->make(true);
    }
}
