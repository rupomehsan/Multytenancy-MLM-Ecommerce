<?php


use Illuminate\Support\Facades\Route;
use App\Modules\MLM\Managements\Wallet\Controllers\WalletController as Controller;

// auth routes

Route::get('/mlm/user-wallet-balance', [Controller::class, 'user_wallet_balance'])->name('mlm.user.wallet.balance');
Route::get('/mlm/wallet-transaction', [Controller::class, 'wallet_transaction'])->name('mlm.wallet.transaction');
