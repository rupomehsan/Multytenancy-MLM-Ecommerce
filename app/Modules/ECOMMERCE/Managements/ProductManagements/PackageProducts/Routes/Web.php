<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\ProductManagements\PackageProducts\Controllers\PackageProductController;

// Package Product routes
Route::get('package-products', [PackageProductController::class, 'index'])->name('PackageProducts.Index');
Route::get('package-products/data', [PackageProductController::class, 'getData'])->name('PackageProducts.Data');
Route::get('package-products/create', [PackageProductController::class, 'create'])->name('PackageProducts.Create');
Route::post('package-products', [PackageProductController::class, 'store'])->name('PackageProducts.Store');
Route::get('package-products/{id}/edit', [PackageProductController::class, 'edit'])->name('PackageProducts.Edit');
Route::put('package-products/{id}', [PackageProductController::class, 'update'])->name('PackageProducts.Update');
Route::delete('package-products/{id}', [PackageProductController::class, 'destroy'])->name('PackageProducts.Destroy');
Route::get('package-products/{id}/manage-items', [PackageProductController::class, 'manageItems'])->name('PackageProducts.ManageItems');
Route::post('package-products/{id}/add-item', [PackageProductController::class, 'addItem'])->name('PackageProducts.AddItem');
Route::put('package-products/{packageId}/items/{itemId}', [PackageProductController::class, 'updateItem'])->name('PackageProducts.UpdateItem');
Route::delete('package-products/{packageId}/items/{itemId}', [PackageProductController::class, 'removeItem'])->name('PackageProducts.RemoveItem');
Route::get('get-product-variants/{productId}', [PackageProductController::class, 'getProductVariants'])->name('GetProductVariants');
Route::post('get-variant-stock/{productId}', [PackageProductController::class, 'getVariantStock'])->name('GetVariantStock');
