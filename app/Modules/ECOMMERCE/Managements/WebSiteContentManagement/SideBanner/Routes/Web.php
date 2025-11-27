<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Controllers\SideBannerController;

Route::get('/add/new/side-banner', [SideBannerController::class, 'addNewSideBanner'])->name('AddNewSideBanner');
Route::post('/save/new/side-banner', [SideBannerController::class, 'saveNewSideBanner'])->name('SaveNewSideBanner');
Route::get('/view/all/side-banner', [SideBannerController::class, 'viewAllSideBanner'])->name('ViewAllSideBanner');
Route::get('/delete/side-banner/{slug}', [SideBannerController::class, 'deleteSideBanner'])->name('DeleteSideBanner');
Route::get('/edit/side-banner/{slug}', [SideBannerController::class, 'editSideBanner'])->name('EditSideBanner');
Route::post('/update/side-banner', [SideBannerController::class, 'updateSideBanner'])->name('UpdateSideBanner');
