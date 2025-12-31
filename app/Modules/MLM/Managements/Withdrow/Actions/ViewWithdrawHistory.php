<?php

namespace App\Modules\MLM\Managements\Withdrow\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        // Query the withdrawal history audit table so admins can see every action
        $query = DB::table('mlm_withdrawal_history as wh')
            ->leftJoin('users as u', 'wh.user_id', '=', 'u.id')
            ->leftJoin('users as admin', 'wh.performed_by', '=', 'admin.id')
            ->select(
                'wh.id',
                'wh.withdrawal_request_id',
                'wh.user_id',
                'wh.action',
                'wh.old_status',
                'wh.new_status',
                'wh.notes',
                'wh.amount',
                'wh.payment_method',
                'wh.transaction_reference',
                'wh.meta',
                'wh.created_at',
                // User details
                'u.name as user_name',
                'u.email as user_email',
                // Admin details
                'admin.name as admin_name'
            )
            ->orderByDesc('wh.created_at');

        try {
            $historyCount = DB::table('mlm_withdrawal_history')->count();
            Log::info('ViewWithdrawHistory - history count: ' . $historyCount);

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
                    $method = $row->payment_method ?? 'N/A';
                    $badgeClass = 'badge-secondary';
                    $lower = strtolower($method);
                    if (str_contains($lower, 'bkash')) $badgeClass = 'badge-primary';
                    elseif (str_contains($lower, 'nagad')) $badgeClass = 'badge-warning';
                    elseif (str_contains($lower, 'bank')) $badgeClass = 'badge-info';
                    elseif (str_contains($lower, 'rocket')) $badgeClass = 'badge-success';

                    return '<span class="badge ' . $badgeClass . '">' . e($method) . '</span>';
                })
                // Account details: show transaction reference and notes
                ->addColumn('account_details', function ($row) {
                    $parts = [];
                    if (!empty($row->transaction_reference)) {
                        $parts[] = '<strong>Ref:</strong> ' . e($row->transaction_reference);
                    }
                    if (!empty($row->notes)) {
                        $parts[] = '<div class="text-muted">' . e($row->notes) . '</div>';
                    }
                    return implode('<br>', $parts) ?: '<span class="text-muted">-</span>';
                })
                // Status badge based on new_status
                ->addColumn('status_badge', function ($row) {
                    $status = $row->new_status ?? $row->action ?? 'unknown';
                    $badgeClass = 'badge-secondary';
                    if ($status === 'completed') $badgeClass = 'badge-success';
                    elseif ($status === 'approved') $badgeClass = 'badge-primary';
                    elseif ($status === 'rejected') $badgeClass = 'badge-danger';

                    $label = ucfirst($status);
                    return '<span class="badge ' . $badgeClass . '">' . e($label) . '</span>';
                })
                // Requested/acted date
                ->addColumn('requested_at', function ($row) {
                    return date('d M Y H:i', strtotime($row->created_at));
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
        } catch (\Exception $e) {
            Log::error('ViewWithdrawHistory failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['data' => []]);
        }
    }
}
