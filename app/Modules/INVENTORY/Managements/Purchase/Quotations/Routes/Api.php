<?php


use Illuminate\Support\Facades\Route;
use App\Modules\INVENTORY\Managements\Purchase\Quotations\Controllers\ProductPurchaseQuotationController;


Route::get('products/search', [ProductPurchaseQuotationController::class, 'searchProduct'])->name('SearchProduct');
Route::get('edit/purchase-product/quotation/{slug}', [ProductPurchaseQuotationController::class, 'apiEditPurchaseProduct'])->name('ApiEditPurchaseProductQuotation');

Route::get('products/search', [ProductPurchaseQuotationController::class, 'searchProduct'])->name('SearchProduct');
