<?php

namespace App\Modules\MLM\Managements\Referral\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

/**
 * ViewReferralActivityLog Action
 * 
 * Powers the server-side DataTable for MLM referral activity logs.
 * Shows all referral-based commission events with proper formatting.
 * 
 * Performance: Optimized with single query, no N+1 issues.
 */
class ViewReferralActivityLog
{
    /**
     * Execute DataTable query for referral activity logs.
     * 
     * Query joins:
     * - mlm_referral_activity_logs (main table)
     * - users (buyer and referrer)
     * - orders (order details)
     * 
     * @param Request $request
     * @return mixed DataTable JSON response
     */
    public static function execute(Request $request)
    {
        // Main query with optimized joins (no N+1 queries)
        $query = DB::table('mlm_referral_activity_logs as ral')
            ->leftJoin('users as buyer', 'ral.buyer_id', '=', 'buyer.id')
            ->leftJoin('users as referrer', 'ral.referrer_id', '=', 'referrer.id')
            ->leftJoin('orders as o', 'ral.order_id', '=', 'o.id')
            ->select(
                'ral.id',
                'ral.buyer_id',
                'ral.referrer_id',
                'ral.order_id',
                'ral.level',
                'ral.commission_amount',
                'ral.status',
                'ral.activity_type',
                'ral.meta',
                'ral.created_at',
                // Buyer details
                'buyer.name as buyer_name',
                'buyer.email as buyer_email',
                // Referrer details
                'referrer.name as referrer_name',
                'referrer.email as referrer_email',
                // Order details
                'o.order_no',
                'o.slug as order_slug'
            )
            ->orderByDesc('ral.created_at');

        return Datatables::of($query)
            // User (Buyer) column with formatted HTML
            ->addColumn('user', function ($row) {
                return '<div class="user-info">
                            <div><strong>' . e($row->buyer_name) . '</strong></div>
                            <div class="text-muted small">' . e($row->buyer_email) . '</div>
                            <span class="badge badge-secondary">#' . $row->buyer_id . '</span>
                        </div>';
            })
            // Referrer column with formatted HTML
            ->addColumn('referrer', function ($row) {
                return '<div class="user-info">
                            <div><strong>' . e($row->referrer_name) . '</strong></div>
                            <div class="text-muted small">' . e($row->referrer_email) . '</div>
                            <span class="badge badge-secondary">#' . $row->referrer_id . '</span>
                        </div>';
            })
            // Level badge (color-coded: 1=blue, 2=green, 3=yellow)
            ->addColumn('level_badge', function ($row) {
                $badgeClass = match ($row->level) {
                    1 => 'badge-primary',
                    2 => 'badge-success',
                    3 => 'badge-warning',
                    default => 'badge-secondary',
                };
                return '<span class="badge ' . $badgeClass . '">Level ' . $row->level . '</span>';
            })
            // Order link (clickable if order exists)
            ->addColumn('order_link', function ($row) {
                if ($row->order_id && $row->order_no) {
                    return '<a href="' . url('admin/order/details', $row->order_slug) . '" 
                               class="badge badge-info" 
                               target="_blank" 
                               title="View Order Details">
                                Order #' . e($row->order_no) . '
                            </a>';
                }
                return '<span class="text-muted">N/A</span>';
            })
            // Commission earned (formatted currency)
            ->addColumn('commission_earned', function ($row) {
                return '<strong class="text-success">' .
                    number_format($row->commission_amount, 2) . ' BDT' .
                    '</strong>';
            })
            // Activity type badge (status-based coloring)
            ->addColumn('activity_type', function ($row) {
                // Determine badge class based on status
                $badgeClass = match ($row->status) {
                    'pending' => 'badge-warning',
                    'approved' => 'badge-info',
                    'paid' => 'badge-success',
                    'cancelled' => 'badge-danger',
                    default => 'badge-secondary',
                };

                // Format activity label
                $activityLabel = match ($row->status) {
                    'pending' => 'Pending Commission',
                    'approved' => 'Commission Approved',
                    'paid' => 'Commission Paid',
                    'cancelled' => 'Commission Cancelled',
                    default => ucfirst($row->activity_type),
                };

                return '<span class="badge ' . $badgeClass . '">' . $activityLabel . '</span>';
            })
            // Date formatted (human-readable)
            ->addColumn('activity_date', function ($row) {
                return date('d M Y, h:i A', strtotime($row->created_at));
            })
            // Enable raw HTML rendering for formatted columns
            ->rawColumns([
                'user',
                'referrer',
                'level_badge',
                'order_link',
                'commission_earned',
                'activity_type'
            ])->make(true);
    }
}
