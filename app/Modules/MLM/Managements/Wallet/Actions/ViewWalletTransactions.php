<?php

namespace App\Modules\MLM\Managements\Wallet\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

/**
 * ViewWalletTransactions Action
 * 
 * Powers the server-side DataTable for MLM wallet transactions.
 * Shows all wallet transaction history with proper formatting.
 * 
 * Performance: Optimized with single query, no N+1 issues.
 */
class ViewWalletTransactions
{
    /**
     * Execute DataTable query for wallet transactions.
     * 
     * Query joins:
     * - mlm_wallet_transactions (main table)
     * - users (transaction owner)
     * - orders (optional reference)
     * - mlm_commissions (optional reference)
     * 
     * @param Request $request
     * @return mixed DataTable JSON response
     */
    public static function execute(Request $request)
    {
        // Main query with optimized joins (no N+1 queries)
        $query = DB::table('mlm_wallet_transactions as wt')
            ->leftJoin('users as u', 'wt.user_id', '=', 'u.id')
            ->leftJoin('orders as o', 'wt.order_id', '=', 'o.id')
            ->leftJoin('mlm_commissions as mc', 'wt.mlm_commission_id', '=', 'mc.id')
            ->select(
                'wt.id',
                'wt.user_id',
                'wt.transaction_type',
                'wt.amount',
                'wt.balance_after',
                'wt.description',
                'wt.order_id',
                'wt.mlm_commission_id',
                'wt.created_at',
                // User details
                'u.name as user_name',
                'u.email as user_email',
                // Order details
                'o.order_no',
                'o.slug as order_slug',
                // Commission details
                'mc.level as commission_level'
            )
            ->orderByDesc('wt.created_at');

        return Datatables::of($query)
            // User column with formatted HTML
            ->addColumn('user', function ($row) {
                return '<div class="user-info">
                            <div><strong>' . e($row->user_name) . '</strong></div>
                            <div class="text-muted small">' . e($row->user_email) . '</div>
                        </div>';
            })
            // User ID badge
            ->addColumn('user_id', function ($row) {
                return '<span class="badge badge-secondary">#' . $row->user_id . '</span>';
            })
            // Transaction type badge (credit/debit indicator)
            ->addColumn('type', function ($row) {
                $amount = (float) $row->amount;
                $type = $amount >= 0 ? 'Credit' : 'Debit';
                $badgeClass = $amount >= 0 ? 'badge-success' : 'badge-danger';
                return '<span class="badge ' . $badgeClass . '">' . $type . '</span>';
            })
            // Transaction source badge
            ->addColumn('source', function ($row) {
                $badgeClass = match ($row->transaction_type) {
                    'commission_credit' => 'badge-primary',
                    'withdrawal' => 'badge-warning',
                    'commission_reversal' => 'badge-danger',
                    'admin_adjustment' => 'badge-info',
                    default => 'badge-secondary',
                };

                $label = match ($row->transaction_type) {
                    'commission_credit' => 'Commission',
                    'withdrawal' => 'Withdrawal',
                    'commission_reversal' => 'Reversal',
                    'admin_adjustment' => 'Admin Adjustment',
                    default => ucfirst(str_replace('_', ' ', $row->transaction_type)),
                };

                // Add level badge for commissions
                $levelBadge = '';
                if ($row->transaction_type === 'commission_credit' && $row->commission_level) {
                    $levelBadge = ' <span class="badge badge-sm badge-dark">L' . $row->commission_level . '</span>';
                }

                return '<span class="badge ' . $badgeClass . '">' . $label . '</span>' . $levelBadge;
            })
            // Amount column (formatted with sign)
            ->addColumn('amount', function ($row) {
                $amount = (float) $row->amount;
                $sign = $amount >= 0 ? '+' : '';
                $colorClass = $amount >= 0 ? 'text-success' : 'text-danger';
                return '<strong class="' . $colorClass . '">' .
                    $sign . number_format(abs($amount), 2) . ' BDT</strong>';
            })
            // Balance after transaction
            ->addColumn('balance_after', function ($row) {
                return '<strong>' . number_format($row->balance_after, 2) . ' BDT</strong>';
            })
            // Order reference (if applicable)
            ->addColumn('reference', function ($row) {
                if ($row->order_id && $row->order_no) {
                    return '<a href="' .  url('admin/order/details') . '/' . $row->order_slug . '" 
                               class="badge badge-info" 
                               target="_blank" 
                               title="View Order">
                                Order #' . e($row->order_no) . '
                            </a>';
                }

                if ($row->description) {
                    return '<span class="text-muted small">' . e(substr($row->description, 0, 30)) .
                        (strlen($row->description) > 30 ? '...' : '') . '</span>';
                }

                return '<span class="text-muted">-</span>';
            })
            // Date formatted (human-readable)
            ->addColumn('date', function ($row) {
                return date('d M Y, h:i A', strtotime($row->created_at));
            })
            // Enable raw HTML rendering for formatted columns
            ->rawColumns([
                'user',
                'user_id',
                'type',
                'source',
                'amount',
                'balance_after',
                'reference'
            ])
            ->make(true);
    }
}
