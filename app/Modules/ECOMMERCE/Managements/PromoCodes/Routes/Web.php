<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\PromoCodes\Controllers\PromoCodeController;




Route::get('/add/new/code', [PromoCodeController::class, 'addPromoCode'])->name('AddPromoCode');
Route::post('/save/promo/code', [PromoCodeController::class, 'savePromoCode'])->name('SavePromoCode');
Route::get('/view/all/promo/codes', [PromoCodeController::class, 'viewAllPromoCodes'])->name('ViewAllPromoCodes');
Route::get('/edit/promo/code/{slug}', [PromoCodeController::class, 'editPromoCode'])->name('EditPromoCode');
Route::post('/update/promo/code', [PromoCodeController::class, 'updatePromoCode'])->name('UpdatePromoCode');
Route::get('/remove/promo/code/{slug}', [PromoCodeController::class, 'removePromoCode'])->name('RemovePromoCode');
