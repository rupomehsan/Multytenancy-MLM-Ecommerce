<?php


use Illuminate\Support\Facades\Route;
use App\Modules\INVENTORY\Managements\WareHouseRoomCartoon\Controllers\ProductWarehouseRoomCartoonController;


Route::get('/add/new/product-warehouse-room-cartoon', [ProductWarehouseRoomCartoonController::class, 'addNewProductWarehouseRoomCartoon'])->name('AddNewProductWarehouseRoomCartoon');
//  Route::post('/subcategory/wise/childcategory', [ProductController::class, 'childcategorySubcategoryWise'])->name('ChildcategorySubcategoryWise');
Route::post('/save/new/product-warehouse-room-cartoon', [ProductWarehouseRoomCartoonController::class, 'saveNewProductWarehouseRoomCartoon'])->name('SaveNewProductWarehouseRoomCartoon');
Route::get('/view/all/product-warehouse-room-cartoon', [ProductWarehouseRoomCartoonController::class, 'viewAllProductWarehouseRoomCartoon'])->name('ViewAllProductWarehouseRoomCartoon');
Route::get('/delete/product-warehouse-room-cartoon/{slug}', [ProductWarehouseRoomCartoonController::class, 'deleteProductWarehouseRoomCartoon'])->name('DeleteProductWarehouseRoomCartoon');
Route::get('/edit/product-warehouse-room-cartoon/{slug}', [ProductWarehouseRoomCartoonController::class, 'editProductWarehouseRoomCartoon'])->name('EditProductWarehouseRoomCartoon');
Route::post('/update/product-warehouse-room-cartoon', [ProductWarehouseRoomCartoonController::class, 'updateProductWarehouseRoomCartoon'])->name('UpdateProductWarehouseRoomCartoon');
Route::post('/get-product-warehouse-room-cartoons', [ProductWarehouseRoomCartoonController::class, 'getProductWarehouseRoomCartoon'])->name('get.product.warehouse.room.cartoon');
