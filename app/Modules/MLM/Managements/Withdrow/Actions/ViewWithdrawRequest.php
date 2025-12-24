<?php

namespace App\Modules\MLM\Managements\Withdrow\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

/**
 * ViewWithdrawRequest Action
 * 
 * Powers the server-side DataTable for withdrawal requests.
 * Shows all withdrawal requests with user info and action buttons.
 * 
 * Performance: Optimized with single query joining users.
 */
class ViewWithdrawRequest
{
    /**
     * Execute DataTable query for withdrawal requests.
     * 
     * Query joins:
     * - mlm_withdrawal_requests (main table)
     * - users (requester info)
     * - users as admin (processor info)
     * 
     * @param Request $request
     * @return mixed DataTable JSON response
     */
    public static function execute(Request $request)
    {
        // Main query with optimized joins
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
            ->orderByRaw("FIELD(wr.status, 'pending', 'processing', 'approved', 'rejected', 'completed')")
            ->orderByDesc('wr.created_at');

        return Datatables::of($query)
            // User column
            ->addColumn('user', function ($row) {
                return '<div class="user-info">
                            <div><strong>' . e($row->user_name) . '</strong></div>
                            <div class="text-muted small">' . e($row->user_email) . '</div>
                        </div>';
            })
            // User ID badge
            ->addColumn('user_id_badge', function ($row) {
                return '<span class="badge badge-secondary">#' . $row->user_id . '</span>';
            })
            // Amount formatted
            ->addColumn('amount_formatted', function ($row) {
                return '<strong class="text-danger">' .
                    number_format($row->amount, 2) . ' BDT</strong>';
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
            // Payment details
            ->addColumn('payment_info', function ($row) {
                return '<span class="text-muted small">' .
                    e(substr($row->payment_details, 0, 50)) .
                    (strlen($row->payment_details) > 50 ? '...' : '') .
                    '</span>';
            })
            // Status badge
            ->addColumn('status_badge', function ($row) {
                $badgeClass = match ($row->status) {
                    'pending' => 'badge-warning',
                    'processing' => 'badge-info',
                    'approved' => 'badge-primary',
                    'completed' => 'badge-success',
                    'rejected' => 'badge-danger',
                    default => 'badge-secondary',
                };
                return '<span class="badge ' . $badgeClass . '">' .
                    ucfirst($row->status) . '</span>';
            })
            // Request date
            ->addColumn('request_date', function ($row) {
                return date('d M Y, h:i A', strtotime($row->created_at));
            })
            // Action buttons
            ->addColumn('action', function ($row) {
                if ($row->status === 'pending') {
                    return '
                        <button class="btn btn-success btn-sm approve-btn" data-id="' . $row->id . '" title="Approve">
                            <i class="fas fa-check"></i> Approve
                        </button>
                        <button class="btn btn-danger btn-sm reject-btn" data-id="' . $row->id . '" title="Reject">
                            <i class="fas fa-times"></i> Reject
                        </button>
                    ';
                } else {
                    $statusLabel = ucfirst($row->status);
                    $badgeClass = match ($row->status) {
                        'completed' => 'badge-success',
                        'rejected' => 'badge-danger',
                        'approved' => 'badge-primary',
                        default => 'badge-secondary',
                    };
                    return '<span class="badge ' . $badgeClass . '">' . $statusLabel . '</span>';
                }
            })
            // Enable raw HTML rendering
            ->rawColumns([
                'user',
                'user_id_badge',
                'amount_formatted',
                'payment_method_badge',
                'payment_info',
                'status_badge',
                'action'
            ])
            ->make(true);
    }
}
