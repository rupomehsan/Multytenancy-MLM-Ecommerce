<?php


use Illuminate\Support\Facades\Route;


// auth routes


Route::get('/mlm/dashboard', [App\Modules\MLM\Managements\Dashboard\Controllers\DashboardController::class, 'dashboard'])->name('mlm.dashboard');
