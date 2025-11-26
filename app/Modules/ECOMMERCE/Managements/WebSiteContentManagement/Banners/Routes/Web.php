<?php


use Illuminate\Support\Facades\Route;
use App\Modules\{path}\Controller;

    Route::get('/view/all/sliders', [BannerController::class, 'viewAllSliders'])->name('ViewAllSliders');
    Route::get('/add/new/slider', [BannerController::class, 'addNewSlider'])->name('AddNewSlider');
    Route::post('/save/new/slider', [BannerController::class, 'saveNewSlider'])->name('SaveNewSlider');
    Route::get('/edit/slider/{slug}', [BannerController::class, 'editSlider'])->name('EditSlider');
    Route::post('/update/slider', [BannerController::class, 'updateSlider'])->name('UpdateSlider');
    Route::get('/rearrange/slider', [BannerController::class, 'rearrangeSlider'])->name('RearrangeSlider');
    Route::post('/update/slider/rearranged/order', [BannerController::class, 'updateRearrangedSliders'])->name('UpdateRearrangedSliders');
    Route::get('/delete/data/{slug}', [BannerController::class, 'deleteData'])->name('DeleteSliderBanner');
    Route::get('/view/all/banners', [BannerController::class, 'viewAllBanners'])->name('ViewAllBanners');
    Route::get('/add/new/banner', [BannerController::class, 'addNewBanner'])->name('AddNewBanner');
    Route::post('/save/new/banner', [BannerController::class, 'saveNewBanner'])->name('SaveNewBanner');
    Route::get('/edit/banner/{slug}', [BannerController::class, 'editBanner'])->name('EditBanner');
    Route::post('/update/banner', [BannerController::class, 'updateBanner'])->name('UpdateBanner');
    Route::get('/rearrange/banners', [BannerController::class, 'rearrangeBanners'])->name('RearrangeBanners');
    Route::post('/update/banners/rearranged/order', [BannerController::class, 'updateRearrangedBanners'])->name('UpdateRearrangedBanners');
    Route::get('/view/promotional/banner', [BannerController::class, 'viewPromotionalBanner'])->name('ViewPromotionalBanner');
    Route::post('/update/promotional/banner', [BannerController::class, 'updatePromotionalBanner'])->name('UpdatePromotionalBanner');
    Route::get('/remove/promotional/banner/header/icon', [BannerController::class, 'removePromotionalHeaderIcon'])->name('RemovePromotionalHeaderIcon');
    Route::get('/remove/promotional/banner/product/image', [BannerController::class, 'removePromotionalProductImage'])->name('RemovePromotionalProductImage');
    Route::get('/remove/promotional/banner/bg/image', [BannerController::class, 'removePromotionalBackgroundImage'])->name('RemovePromotionalBackgroundImage');

