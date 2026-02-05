<?php


use Illuminate\Support\Facades\Route;
use App\Modules\INVENTORY\Managements\Purchase\PurchaseOrders\Controllers\ProductPurchaseOrderController;


Route::get('edit/purchase-product/order/{slug}', [ProductPurchaseOrderController::class, 'apiEditPurchaseProduct'])->name('ApiEditPurchaseProductOrder');