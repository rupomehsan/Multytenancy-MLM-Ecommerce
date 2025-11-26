<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\Configurations\Controllers\ConfigController;

//  measurement routes
Route::get('/view/all/units', [ConfigController::class, 'viewAllUnits'])->name('ViewAllUnits');
Route::get('/delete/unit/{id}', [ConfigController::class, 'deleteUnit'])->name('DeleteUnit');
Route::get('/get/unit/info/{id}', [ConfigController::class, 'getUnitInfo'])->name('GetUnitInfo');
Route::post('/update/unit', [ConfigController::class, 'updateUnitInfo'])->name('UpdateUnitInfo');
Route::post('/create/new/unit', [ConfigController::class, 'createNewUnit'])->name('CreateNewUnit');
