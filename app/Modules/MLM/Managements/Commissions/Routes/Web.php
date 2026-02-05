<?php


use Illuminate\Support\Facades\Route;
use App\Modules\MLM\Managements\Commissions\Controllers\CommissionController;

// 
Route::get('/mlm/commissions/settings', [CommissionController::class, 'settings'])->name('mlm.commissions.settings');
Route::post('/mlm/commissions/settings', [CommissionController::class, 'update'])->name('mlm.commissions.update');
Route::get('/mlm/commissions/record', [CommissionController::class, 'record'])->name('mlm.commissions.record');
