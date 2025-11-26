<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\Admin\HomeController;

Route::get('/view/payment/history', [HomeController::class, 'viewPaymentHistory'])->name('ViewPaymentHistory');
