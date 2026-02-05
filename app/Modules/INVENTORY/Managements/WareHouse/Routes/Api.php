<?php


use Illuminate\Support\Facades\Route;
use App\Modules\INVENTORY\Managements\WareHouse\Controllers\ProductWarehouseController;


Route::get('get-rooms/{warehouseId}', [ProductWarehouseController::class, 'apiGetetWarehouseRooms']);
Route::get('get-cartoons/{warehouseId}/{roomId}', [ProductWarehouseController::class, 'apiGetetWarehouseRoomCartoons']);
