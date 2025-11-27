<?php


use Illuminate\Support\Facades\Route;
use App\Modules\INVENTORY\Managements\Purchase\Quotations\Controllers\ProductPurchaseQuotationController;

Route::get('/add/new/purchase-product/quotation', [ProductPurchaseQuotationController::class, 'addNewPurchaseProductQuotation'])->name('AddNewPurchaseProductQuotation');
Route::post('/save/new/purchase-product/quotation', [ProductPurchaseQuotationController::class, 'saveNewPurchaseProductQuotation'])->name('SaveNewPurchaseProductQuotation');
Route::get('/view/all/purchase-product/quotation', [ProductPurchaseQuotationController::class, 'viewAllPurchaseProductQuotation'])->name('ViewAllPurchaseProductQuotation');
Route::get('/delete/purchase-product/quotation/{slug}', [ProductPurchaseQuotationController::class, 'deletePurchaseProductQuotation'])->name('DeletePurchaseProductQuotation');
Route::get('/edit/purchase-product/quotation/{slug}', [ProductPurchaseQuotationController::class, 'editPurchaseProductQuotation'])->name('EditPurchaseProductQuotation');
Route::get('/edit/purchase-product/sales/quotation/{slug}', [ProductPurchaseQuotationController::class, 'editPurchaseProductSalesQuotation'])->name('EditPurchaseProductSalesQuotation');
Route::get('api/edit/purchase-product/quotation/{slug}', [ProductPurchaseQuotationController::class, 'apiEditPurchaseProduct'])->name('ApiEditPurchaseProductQuotation');
Route::post('/update/purchase-product/quotation', [ProductPurchaseQuotationController::class, 'updatePurchaseProductQuotation'])->name('UpdatePurchaseProductQuotation');
Route::post('/update/purchase-product/sales/quotation', [ProductPurchaseQuotationController::class, 'updatePurchaseProductSalesQuotation'])->name('UpdatePurchaseProductSalesQuotation');

Route::get('/api/products/search', [ProductPurchaseQuotationController::class, 'searchProduct'])->name('SearchProduct');
