<?php


use Illuminate\Support\Facades\Route;
use App\Modules\MLM\Managements\Reports\Controllers\ReportController;

// auth routes

Route::get('/mlm/reports/referral', [ReportController::class, 'referral'])->name('mlm.reports.referral');
Route::get('/mlm/reports/commission', [ReportController::class, 'commission'])->name('mlm.reports.commission');
Route::get('/mlm/reports/user-performance', [ReportController::class, 'user_performance'])->name('mlm.reports.user_performance');
Route::get('/mlm/reports/top-earners', [ReportController::class, 'top_earners'])->name('mlm.reports.top_earners');
Route::get('/mlm/reports/withdrawal', [ReportController::class, 'withdrawal'])->name('mlm.reports.withdrawal');
Route::get('/mlm/reports/activity-log', [ReportController::class, 'activity_log'])->name('mlm.reports.activity_log');
Route::get('/mlm/reports/wallet-summary', [ReportController::class, 'wallet_summary'])->name('mlm.reports.wallet_summary');
