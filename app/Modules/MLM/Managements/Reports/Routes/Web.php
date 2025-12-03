<?php


use Illuminate\Support\Facades\Route;
use App\Modules\MLM\Managements\Reports\Controllers\ReportController;

// auth routes
Route::get('/mlm/reports', [ReportController::class, 'index'])->name('mlm.reports');
