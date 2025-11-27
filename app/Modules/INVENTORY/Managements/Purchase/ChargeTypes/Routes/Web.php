<?php


use Illuminate\Support\Facades\Route;
use App\Modules\INVENTORY\Managements\Purchase\ChargeTypes\Controllers\ProductPurchaseChargeController;


Route::get('/add/new/purchase-product/charge', [ProductPurchaseChargeController::class, 'addNewPurchaseProductCharge'])->name('AddNewPurchaseProductCharge');
Route::post('/save/new/purchase-product/charge', [ProductPurchaseChargeController::class, 'saveNewPurchaseProductCharge'])->name('SaveNewPurchaseProductCharge');
Route::get('/view/all/purchase-product/charge', [ProductPurchaseChargeController::class, 'viewAllPurchaseProductCharge'])->name('ViewAllPurchaseProductCharge');
Route::get('/delete/purchase-product/charge/{slug}', [ProductPurchaseChargeController::class, 'deletePurchaseProductCharge'])->name('DeletePurchaseProductCharge');
Route::get('/edit/purchase-product/charge/{slug}', [ProductPurchaseChargeController::class, 'editPurchaseProductCharge'])->name('EditPurchaseProductCharge');
Route::post('/update/purchase-product/charge', [ProductPurchaseChargeController::class, 'updatePurchaseProductCharge'])->name('UpdatePurchaseProductCharge');
