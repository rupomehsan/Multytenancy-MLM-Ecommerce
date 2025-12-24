<?php

namespace App\Modules\MLM\Managements\Referral\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ViewReferralList
{
    /**
     * Execute optimized referral list query.
     * Shows ONLY users who have referred at least one user.
     * Pre-calculates level 1, 2, 3 counts using SQL joins (no N+1 queries).
     *
     * @param Request $request
     * @return mixed
     */
    public static function execute(Request $request)
    {
        // Subquery: Count Level 1 referrals (direct referrals)
        // For each user, count users where referred_by = user.id
        $level1Subquery = DB::table('users as l1')
            ->select('l1.referred_by', DB::raw('COUNT(DISTINCT l1.id) as level_1_count'))
            ->whereNotNull('l1.referred_by')
            ->groupBy('l1.referred_by');

        // Subquery: Count Level 2 referrals (referrals of direct referrals)
        // l1 = Level 1 users, l2 = users referred by l1
        $level2Subquery = DB::table('users as l1')
            ->join('users as l2', 'l1.id', '=', 'l2.referred_by')
            ->select('l1.referred_by', DB::raw('COUNT(DISTINCT l2.id) as level_2_count'))
            ->whereNotNull('l1.referred_by')
            ->whereNotNull('l2.referred_by')
            ->groupBy('l1.referred_by');

        // Subquery: Count Level 3 referrals (referrals of level 2 users)
        // l1 = Level 1, l2 = Level 2, l3 = users referred by l2
        $level3Subquery = DB::table('users as l1')
            ->join('users as l2', 'l1.id', '=', 'l2.referred_by')
            ->join('users as l3', 'l2.id', '=', 'l3.referred_by')
            ->select('l1.referred_by', DB::raw('COUNT(DISTINCT l3.id) as level_3_count'))
            ->whereNotNull('l1.referred_by')
            ->whereNotNull('l2.referred_by')
            ->whereNotNull('l3.referred_by')
            ->groupBy('l1.referred_by');

        // Main query: Get ONLY users who have at least one direct referral
        $query = DB::table('users as u')
            ->leftJoin('orders as o', 'u.id', '=', 'o.user_id')
            ->leftJoinSub($level1Subquery, 'lvl1', function ($join) {
                $join->on('u.id', '=', 'lvl1.referred_by');
            })
            ->leftJoinSub($level2Subquery, 'lvl2', function ($join) {
                $join->on('u.id', '=', 'lvl2.referred_by');
            })
            ->leftJoinSub($level3Subquery, 'lvl3', function ($join) {
                $join->on('u.id', '=', 'lvl3.referred_by');
            })
            // Filter: Only users who ARE referrers (have at least one direct referral)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('users as referred_users')
                    ->whereColumn('referred_users.referred_by', 'u.id');
            })
            ->select(
                'u.id',
                'u.name',
                'u.email',
                'u.phone',
                'u.created_at',
                // Pre-calculated level counts (no PHP loops)
                DB::raw('MAX(COALESCE(lvl1.level_1_count, 0)) as level_1_count'),
                DB::raw('MAX(COALESCE(lvl2.level_2_count, 0)) as level_2_count'),
                DB::raw('MAX(COALESCE(lvl3.level_3_count, 0)) as level_3_count'),
                DB::raw('MAX(COALESCE(lvl1.level_1_count, 0)) + MAX(COALESCE(lvl2.level_2_count, 0)) + MAX(COALESCE(lvl3.level_3_count, 0)) as total_referrals'),
                // Order statistics
                DB::raw('COUNT(DISTINCT o.id) as total_orders'),
                DB::raw('COALESCE(SUM(o.total), 0) as total_spent')
            )
            ->groupBy('u.id', 'u.name', 'u.email', 'u.phone', 'u.created_at');

        return Datatables::of($query)
            ->addColumn('user_info', function ($row) {
                return '<div class="user-info">
                            <div><strong>' . e($row->name) . '</strong></div>
                            <div class="text-muted small">' . e($row->email) . '</div>
                        </div>';
            })
            ->addColumn('user_id', function ($row) {
                return '<span class="badge badge-secondary">#' . $row->id . '</span>';
            })
            ->addColumn('phone', function ($row) {
                return $row->phone ?? '<span class="text-muted">N/A</span>';
            })
            ->addColumn('level_1', function ($row) {
                return '<span class="badge badge-primary">' . $row->level_1_count . '</span>';
            })
            ->addColumn('level_2', function ($row) {
                return '<span class="badge badge-success">' . $row->level_2_count . '</span>';
            })
            ->addColumn('level_3', function ($row) {
                return '<span class="badge badge-warning">' . $row->level_3_count . '</span>';
            })
            ->addColumn('total_referrals', function ($row) {
                return '<span class="badge badge-info">' . $row->total_referrals . '</span>';
            })
            ->addColumn('total_orders', function ($row) {
                return '<span class="badge badge-secondary">' . $row->total_orders . '</span>';
            })
            ->addColumn('total_spent', function ($row) {
                return '<strong>' . number_format($row->total_spent, 2) . ' BDT</strong>';
            })
            ->addColumn('joined_date', function ($row) {
                return date('d M Y', strtotime($row->created_at));
            })
            ->addColumn('actions', function ($row) {
                $treeUrl = route('mlm.referral.tree', ['user_id' => $row->id]);
                return '<a href="' . $treeUrl . '" class="btn btn-sm btn-info" title="View Referral Tree">
                            <i class="fas fa-sitemap"></i> View Tree
                        </a>';
            })
            ->rawColumns(['user_info', 'user_id', 'phone', 'level_1', 'level_2', 'level_3', 'total_referrals', 'total_orders', 'total_spent', 'actions'])
            ->make(true);
    }
}
