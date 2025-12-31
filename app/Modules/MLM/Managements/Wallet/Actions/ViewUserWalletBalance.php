<?php

namespace App\Modules\MLM\Managements\Wallet\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

/**
 * ViewUserWalletBalance Action
 * 
 * Powers the server-side DataTable for user wallet balances.
 * Shows only customers (user_type = 3) with their wallet balances.
 * 
 * Performance: Optimized single-table query with index on user_type.
 */
class ViewUserWalletBalance
{
    /**
     * Execute DataTable query for user wallet balances.
     * 
     * Query filters:
     * - Only customers (user_type = 3)
     * - Active and inactive users included
     * 
     * @param Request $request
     * @return mixed DataTable JSON response
     */
    public static function execute(Request $request)
    {
        // Main query - only customers with wallet balances
        $query = DB::table('users')
            ->select(
                'id as user_id',
                'name',
                'email',
                'phone',
                'wallet_balance',
                'created_at'
            )
            ->where('user_type', 3) // Only customers
            ->where('wallet_balance', '>', 0) // Only show balances greater than zero
            ->orderBy('wallet_balance', 'DESC');

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
            ->addColumn('wallet_balance_formatted', function ($row) {
                $balance = (float) $row->wallet_balance;
                $colorClass = $balance > 0 ? 'text-success' : 'text-muted';
                return '<strong class="' . $colorClass . '">' .
                    number_format($balance, 2) . ' BDT</strong>';
            })
            // Enable raw HTML rendering
            ->rawColumns([
                'user',
                'phone_number',
                'wallet_balance_formatted'
            ])
            ->make(true);
    }
}
