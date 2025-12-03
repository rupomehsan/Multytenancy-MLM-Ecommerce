<?php


use Illuminate\Support\Facades\Route;
use App\Modules\MLM\Managements\Withdrow\Controllers\WithdrowController as Controller;

// auth routes

Route::get('/mlm/user-withdraw-request', [Controller::class, 'withdrow_request'])->name('mlm.user.withdraw.request');
Route::get('/mlm/withdraw-history', [Controller::class, 'withdrow_history'])->name('mlm.withdraw.history');
