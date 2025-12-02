<?php


use Illuminate\Support\Facades\Route;
use App\Modules\INVENTORY\Managements\Purchase\PurchaseOrders\Controllers\ProductPurchaseOrderController;


Route::get('/add/new/purchase-product/order', [ProductPurchaseOrderController::class, 'addNewPurchaseProductOrder'])->name('AddNewPurchaseProductOrder');
Route::post('/save/new/purchase-product/order', [ProductPurchaseOrderController::class, 'saveNewPurchaseProductOrder'])->name('SaveNewPurchaseProductOrder');
Route::get('/view/all/purchase-product/order', [ProductPurchaseOrderController::class, 'viewAllPurchaseProductOrder'])->name('ViewAllPurchaseProductOrder');
Route::get('/delete/purchase-product/order/{slug}', [ProductPurchaseOrderController::class, 'deletePurchaseProductOrder'])->name('DeletePurchaseProductOrder');
Route::get('/edit/purchase-product/order/{slug}', [ProductPurchaseOrderController::class, 'editPurchaseProductOrder'])->name('EditPurchaseProductOrder');
Route::get('/edit/purchase-product/order/confirm/{slug}', [ProductPurchaseOrderController::class, 'editPurchaseProductOrderConfirm'])->name('EditPurchaseProductOrderConfirm');
Route::get('api/edit/purchase-product/order/{slug}', [ProductPurchaseOrderController::class, 'apiEditPurchaseProduct'])->name('ApiEditPurchaseProductOrder');
Route::post('/update/purchase-product/order', [ProductPurchaseOrderController::class, 'updatePurchaseProductOrder'])->name('UpdatePurchaseProductOrder');
