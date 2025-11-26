<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\Configurations\Controllers\ConfigController;

// auth routes
Route::get('/view/all/flags', [ConfigController::class, 'viewAllFlags'])->name('ViewAllFlags');
Route::get('/delete/flag/{slug}', [ConfigController::class, 'deleteFlag'])->name('DeleteFlag');
Route::get('/feature/flag/{id}', [ConfigController::class, 'featureFlag'])->name('FeatureFlag');
Route::get('/get/flag/info/{slug}', [ConfigController::class, 'getFlagInfo'])->name('GetFlagInfo');
Route::post('/update/flag', [ConfigController::class, 'updateFlagInfo'])->name('UpdateFlagInfo');
Route::post('/create/new/flag', [ConfigController::class, 'createNewFlag'])->name('CreateNewFlag');
Route::get('/rearrange/flags', [ConfigController::class, 'rearrangeFlags'])->name('RearrangeFlags');
Route::post('/save/rearranged/flags', [ConfigController::class, 'saveRearrangedFlags'])->name('SaveRearrangedFlags');
