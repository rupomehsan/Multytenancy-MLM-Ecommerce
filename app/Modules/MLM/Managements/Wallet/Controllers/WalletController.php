<?php

namespace App\Modules\MLM\Managements\Wallet\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Modules\MLM\Managements\Wallet\Actions\ViewWalletTransactions;
use App\Modules\MLM\Managements\Wallet\Actions\ViewUserWalletBalance;


class WalletController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('MLM/Managements/Wallet');
    }

    public function user_wallet_balance(Request $request)
    {
        if ($request->ajax()) {
            return ViewUserWalletBalance::execute($request);
        }
        return view('user_wallet_balance');
    }

    public function wallet_transaction(Request $request)
    {
        if ($request->ajax()) {
            return ViewWalletTransactions::execute($request);
        }
        return view('wallet_transaction');
    }
}
