<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Controllers\UnitController;

//  measurement routes
Route::get('/view/all/units', [UnitController::class, 'viewAllUnits'])->name('ViewAllUnits');
Route::get('/delete/unit/{id}', [UnitController::class, 'deleteUnit'])->name('DeleteUnit');
Route::get('/get/unit/info/{id}', [UnitController::class, 'getUnitInfo'])->name('GetUnitInfo');
Route::post('/update/unit', [UnitController::class, 'updateUnitInfo'])->name('UpdateUnitInfo');
Route::post('/create/new/unit', [UnitController::class, 'createNewUnit'])->name('CreateNewUnit');
