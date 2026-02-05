<?php


use Illuminate\Support\Facades\Route;
use App\Modules\INVENTORY\Managements\WareHouse\Controllers\ProductWarehouseController;

Route::get('/add/new/product-warehouse', [ProductWarehouseController::class, 'addNewProductWarehouse'])->name('AddNewProductWarehouse');
//  Route::post('/subcategory/wise/childcategory', [ProductController::class, 'childcategorySubcategoryWise'])->name('ChildcategorySubcategoryWise');
Route::post('/save/new/product-warehouse', [ProductWarehouseController::class, 'saveNewProductWarehouse'])->name('SaveNewProductWarehouse');
Route::get('/view/all/product-warehouse', [ProductWarehouseController::class, 'viewAllProductWarehouse'])->name('ViewAllProductWarehouse');
Route::get('/delete/product-warehouse/{slug}', [ProductWarehouseController::class, 'deleteProductWarehouse'])->name('DeleteProductWarehouse');
Route::get('/edit/product-warehouse/{slug}', [ProductWarehouseController::class, 'editProductWarehouse'])->name('EditProductWarehouse');
Route::post('/update/product-warehouse', [ProductWarehouseController::class, 'updateProductWarehouse'])->name('UpdateProductWarehouse');
//  Route::post('/add/another/variant', [ProductController::class, 'addAnotherVariant'])->name('AddAnotherVariant');
//  Route::get('/delete/product/variant/{id}', [ProductController::class, 'deleteProductVariant'])->name('DeleteProductVariant');
//  Route::get('/products/from/excel', [ProductController::class, 'productsFromExcel'])->name('ProductsFromExcel');
//  Route::post('/upload/product/from/excel', [ProductController::class, 'uploadProductsFromExcel'])->name('UploadProductsFromExcel');
Route::get('/get-warehouse-rooms', [ProductWarehouseController::class, 'getWarehouseRooms']);
Route::get('/get-warehouse-room-cartoons', [ProductWarehouseController::class, 'getWarehouseRoomCartoons']);


  // Route::get('get-rooms/{warehouseId}', [WarehouseController::class, 'getRooms'])->name('get.rooms');
    // Route::get('get-cartoons/{roomId}', [WarehouseController::class, 'getCartoons'])->name('get.cartoons');
