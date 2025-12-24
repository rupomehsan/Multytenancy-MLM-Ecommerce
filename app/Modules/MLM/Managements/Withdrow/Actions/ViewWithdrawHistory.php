<?php

namespace App\Modules\MLM\Managements\Withdrow\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

/**
 * ViewWithdrawHistory Action
 * 
 * Powers the server-side DataTable for withdrawal history.
 * Shows all processed (approved/rejected/completed) withdrawal requests.
 * 
 * Performance: Optimized with single query joining users.
 */
class ViewWithdrawHistory
{
    /**
     * Execute DataTable query for withdrawal history.
     * 
     * Query joins:
     * - mlm_withdrawal_requests (main table)
     * - users (requester info)
     * - users as admin (processor info)
     * 
     * Filters: Only shows non-pending requests
     * 
     * @param Request $request
     * @return mixed DataTable JSON response
     */
    public static function execute(Request $request)
    {
        // Main query with optimized joins - exclude pending requests
        $query = DB::table('mlm_withdrawal_requests as wr')
            ->leftJoin('users as u', 'wr.user_id', '=', 'u.id')
            ->leftJoin('users as admin', 'wr.processed_by', '=', 'admin.id')
            ->select(
                'wr.id',
                'wr.user_id',
                'wr.amount',
                'wr.payment_method',
                'wr.payment_details',
                'wr.status',
                'wr.processed_at',
                'wr.admin_notes',
                'wr.created_at',
                // User details
                'u.name as user_name',
                'u.email as user_email',
                // Admin details
                'admin.name as admin_name'
            )
            ->whereIn('wr.status', ['approved', 'rejected', 'completed'])
            ->orderByDesc('wr.processed_at');

        return Datatables::of($query)
            // User column
            ->addColumn('user', function ($row) {
                return '<div class="user-info">
                            <div><strong>' . e($row->user_name) . '</strong></div>
                            <div class="text-muted small">' . e($row->user_email) . '</div>
                            <span class="badge badge-secondary">#' . $row->user_id . '</span>
                        </div>';
            })
            // Amount formatted
            ->addColumn('amount_formatted', function ($row) {
                return '<strong>' . number_format($row->amount, 2) . ' BDT</strong>';
            })
            // Payment method badge
            ->addColumn('payment_method_badge', function ($row) {
                $badgeClass = match (strtolower($row->payment_method)) {
                    'bkash' => 'badge-primary',
                    'nagad' => 'badge-warning',
                    'bank', 'bank transfer' => 'badge-info',
                    'rocket' => 'badge-success',
                    default => 'badge-secondary',
                };
                return '<span class="badge ' . $badgeClass . '">' .
                    e($row->payment_method) . '</span>';
            })
            // Payment details (account info)
            ->addColumn('account_details', function ($row) {
                return '<span class="text-muted">' . e($row->payment_details) . '</span>';
            })
            // Status badge
            ->addColumn('status_badge', function ($row) {
                $badgeClass = match ($row->status) {
                    'completed' => 'badge-success',
                    'approved' => 'badge-primary',
                    'rejected' => 'badge-danger',
                    default => 'badge-secondary',
                };

                $statusLabel = match ($row->status) {
                    'completed' => 'Completed',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                    default => ucfirst($row->status),
                };

                return '<span class="badge ' . $badgeClass . '">' . $statusLabel . '</span>';
            })
            // Requested date
            ->addColumn('requested_at', function ($row) {
                return date('d M Y', strtotime($row->created_at));
            })
            // Processed date
            ->addColumn('processed_date', function ($row) {
                if ($row->processed_at) {
                    return date('d M Y', strtotime($row->processed_at));
                }
                return '<span class="text-muted">-</span>';
            })
            // Enable raw HTML rendering
            ->rawColumns([
                'user',
                'amount_formatted',
                'payment_method_badge',
                'account_details',
                'status_badge',
                'processed_date'
            ])
            ->make(true);
    }
}
