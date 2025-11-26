<?php


use Illuminate\Support\Facades\Route;
use App\Modules\Inventory\Managements\WarehouseRoom\Controllers\ProductWarehouseRoomController;
use App\Modules\Inventory\Managements\WarehouseRoom\Database\Models\ProductWarehouseRoom;

Route::get('/add/new/product-warehouse-room', [ProductWarehouseRoomController::class, 'addNewProductWarehouseRoom'])->name('AddNewProductWarehouseRoom');
//  Route::post('/subcategory/wise/childcategory', [ProductController::class, 'childcategorySubcategoryWise'])->name('ChildcategorySubcategoryWise');
Route::post('/save/new/product-warehouse-room', [ProductWarehouseRoomController::class, 'saveNewProductWarehouseRoom'])->name('SaveNewProductWarehouseRoom');
Route::get('/view/all/product-warehouse-room', [ProductWarehouseRoomController::class, 'viewAllProductWarehouseRoom'])->name('ViewAllProductWarehouseRoom');
Route::get('/delete/product-warehouse-room/{slug}', [ProductWarehouseRoomController::class, 'deleteProductWarehouseRoom'])->name('DeleteProductWarehouseRoom');
Route::get('/edit/product-warehouse-room/{slug}', [ProductWarehouseRoomController::class, 'editProductWarehouseRoom'])->name('EditProductWarehouseRoom');
Route::post('/update/product-warehouse-room', [ProductWarehouseRoomController::class, 'updateProductWarehouseRoom'])->name('UpdateProductWarehouseRoom');
Route::post('/get-product-warehouse-rooms', [ProductWarehouseRoomController::class, 'getProductWarehouseRooms'])->name('get.product.warehouse.rooms');
Route::get('/get-warehouse-rooms/{warehouseId}', function ($warehouseId) {
    $rooms = ProductWarehouseRoom::where('product_warehouse_id', $warehouseId)->get();
    return response()->json(['rooms' => $rooms]);
});
