<?php


use Illuminate\Support\Facades\Route;
use App\Modules\INVENTORY\Managements\Suppliers\Controllers\ProductSupplierController;

Route::get('/add/new/product-supplier', [ProductSupplierController::class, 'addNewProductSupplier'])->name('AddNewProductSupplier');
Route::post('/save/new/product-supplier', [ProductSupplierController::class, 'saveNewProductSupplier'])->name('SaveNewProductSupplier');
Route::get('/view/all/product-supplier', [ProductSupplierController::class, 'viewAllProductSupplier'])->name('ViewAllProductSupplier');
Route::get('/delete/product-supplier/{slug}', [ProductSupplierController::class, 'deleteProductSupplier'])->name('DeleteProductSupplier');
Route::get('/edit/product-supplier/{slug}', [ProductSupplierController::class, 'editProductSupplier'])->name('EditProductSupplier');
Route::post('/update/product-supplier', [ProductSupplierController::class, 'updateProductSupplier'])->name('UpdateProductSupplier');
