<?php

use Illuminate\Support\Facades\Route;


use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Controllers\ColorController;

// config routes for sizes
Route::post('/create/new/color', [ColorController::class, 'addNewColor'])->name('AddNewColor');
Route::get('/view/all/colors', [ColorController::class, 'viewAllColors'])->name('ViewAllColors');
Route::get('/delete/color/{id}', [ColorController::class, 'deleteColor'])->name('DeleteColor');
Route::get('/get/color/info/{id}', [ColorController::class, 'getColorInfo'])->name('GetColorInfo');
Route::post('/update/color', [ColorController::class, 'updateColor'])->name('UpdateColor');
