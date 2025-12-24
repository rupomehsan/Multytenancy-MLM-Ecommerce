<?php

namespace App\Modules\MLM\Managements\Wallet\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

/**
 * ViewUserWalletBalance Action
 * 
 * Powers the server-side DataTable for user wallet balances.
 * Shows all users with their wallet balances and pending withdrawals.
 * 
 * Performance: Optimized with single query joining users and wallet balances.
 */
class ViewUserWalletBalance
{
    /**
     * Execute DataTable query for user wallet balances.
     * 
     * Query joins:
     * - users (main table)
     * - mlm_user_wallet_balances (balance data)
     * 
     * @param Request $request
     * @return mixed DataTable JSON response
     */
    public static function execute(Request $request)
    {
        // Main query with optimized joins
        $query = DB::table('users as u')
            ->leftJoin('mlm_user_wallet_balances as wb', 'u.id', '=', 'wb.user_id')
            ->select(
                'u.id as user_id',
                'u.name',
                'u.email',
                'u.phone',
                'u.created_at',
                // Wallet balance details (with COALESCE for users without wallet records)
                DB::raw('COALESCE(wb.total_balance, 0) as total_balance'),
                DB::raw('COALESCE(wb.pending_withdrawal, 0) as pending_withdrawal'),
                DB::raw('COALESCE(wb.total_earned, 0) as total_earned'),
                DB::raw('COALESCE(wb.total_withdrawn, 0) as total_withdrawn'),
                'wb.last_transaction_at'
            )
            ->orderByRaw('COALESCE(wb.total_balance, 0) DESC');

        return Datatables::of($query)
            // User info column
            ->addColumn('user', function ($row) {
                return '<div class="user-info">
                            <div><strong>' . e($row->name) . '</strong></div>
                            <div class="text-muted small">' . e($row->email) . '</div>
                        </div>';
            })
            // User ID badge
            ->addColumn('user_id_badge', function ($row) {
                return '<span class="badge badge-secondary">#' . $row->user_id . '</span>';
            })
            // Phone number
            ->addColumn('phone_number', function ($row) {
                return $row->phone ? '<span class="text-muted">' . e($row->phone) . '</span>' :
                    '<span class="text-muted">N/A</span>';
            })
            // Total wallet balance (formatted)
            ->addColumn('wallet_balance', function ($row) {
                $balance = (float) $row->total_balance;
                $colorClass = $balance > 0 ? 'text-success' : 'text-muted';
                return '<strong class="' . $colorClass . '">' .
                    number_format($balance, 2) . ' BDT</strong>';
            })
            // Pending withdrawal (formatted)
            ->addColumn('pending_amount', function ($row) {
                $pending = (float) $row->pending_withdrawal;
                if ($pending > 0) {
                    return '<span class="badge badge-warning">' .
                        number_format($pending, 2) . ' BDT</span>';
                }
                return '<span class="text-muted">0.00 BDT</span>';
            })
            // Last transaction date
            ->addColumn('last_transaction', function ($row) {
                if ($row->last_transaction_at) {
                    return date('d M Y, h:i A', strtotime($row->last_transaction_at));
                }
                return '<span class="text-muted">No transactions</span>';
            })
            // Enable raw HTML rendering
            ->rawColumns([
                'user',
                'user_id_badge',
                'phone_number',
                'wallet_balance',
                'pending_amount',
                'last_transaction'
            ])
            ->make(true);
    }
}
