<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Controllers\FlagController;

// auth routes
Route::get('/view/all/flags', [FlagController::class, 'viewAllFlags'])->name('ViewAllFlags');
Route::get('/delete/flag/{slug}', [FlagController::class, 'deleteFlag'])->name('DeleteFlag');
Route::get('/feature/flag/{id}', [FlagController::class, 'featureFlag'])->name('FeatureFlag');
Route::get('/get/flag/info/{slug}', [FlagController::class, 'getFlagInfo'])->name('GetFlagInfo');
Route::post('/update/flag', [FlagController::class, 'updateFlagInfo'])->name('UpdateFlagInfo');
Route::post('/create/new/flag', [FlagController::class, 'createNewFlag'])->name('CreateNewFlag');
Route::get('/rearrange/flags', [FlagController::class, 'rearrangeFlags'])->name('RearrangeFlags');
Route::post('/save/rearranged/flags', [FlagController::class, 'saveRearrangedFlags'])->name('SaveRearrangedFlags');
