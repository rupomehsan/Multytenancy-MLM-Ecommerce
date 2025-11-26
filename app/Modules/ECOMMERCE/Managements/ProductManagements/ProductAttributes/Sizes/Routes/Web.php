<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\Configurations\Controllers\ConfigController;



// config routes for sizes
Route::get('/view/all/sizes', [ConfigController::class, 'viewAllSizes'])->name('ViewAllSizes');
Route::get('/delete/size/{id}', [ConfigController::class, 'deleteSize'])->name('DeleteSize');
Route::get('/get/size/info/{id}', [ConfigController::class, 'getSizeInfo'])->name('GetSizeInfo');
Route::post('/update/size', [ConfigController::class, 'updateSizeInfo'])->name('UpdateSizeInfo');
Route::post('/create/new/size', [ConfigController::class, 'createNewSize'])->name('CreateNewSize');
Route::get('/rearrange/size', [ConfigController::class, 'rearrangeSize'])->name('RearrangeSize');
Route::post('/save/rearranged/sizes', [ConfigController::class, 'saveRearrangedSizes'])->name('SaveRearrangedSizes');
