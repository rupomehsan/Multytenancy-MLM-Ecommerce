<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Controllers\ProductSizeController;



// config routes for sizes
Route::get('/view/all/sizes', [ProductSizeController::class, 'viewAllSizes'])->name('ViewAllSizes');
Route::get('/delete/size/{id}', [ProductSizeController::class, 'deleteSize'])->name('DeleteSize');
Route::get('/get/size/info/{id}', [ProductSizeController::class, 'getSizeInfo'])->name('GetSizeInfo');
Route::post('/update/size', [ProductSizeController::class, 'updateSizeInfo'])->name('UpdateSizeInfo');
Route::post('/create/new/size', [ProductSizeController::class, 'createNewSize'])->name('CreateNewSize');
Route::get('/rearrange/size', [ProductSizeController::class, 'rearrangeSize'])->name('RearrangeSize');
Route::post('/save/rearranged/sizes', [ProductSizeController::class, 'saveRearrangedSizes'])->name('SaveRearrangedSizes');
