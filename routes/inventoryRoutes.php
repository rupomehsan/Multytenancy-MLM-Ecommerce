<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Outlet\SupplierSourceController;
use App\Http\Controllers\Inventory\ProductSupplierController;
use App\Modules\Inventory\Managements\WareHouse\Controllers\ProductWarehouseController;
use App\Http\Controllers\Inventory\Models\ProductWarehouseRoom;
use App\Http\Controllers\Inventory\ProductPurchaseOrderController;
use App\Http\Controllers\Inventory\ProductWarehouseRoomController;
use App\Http\Controllers\Inventory\ProductPurchaseChargeController;
use App\Http\Controllers\Inventory\ProductPurchaseQuotationController;
use App\Http\Controllers\Inventory\ProductWarehouseRoomCartoonController;

Route::group(['middleware' => ['auth', 'CheckUserType', 'DemoMode']], function () {

    // product warehouse routes

    require __DIR__ . '/../app/Modules/INVENTORY/Managements/WareHouse/Routes/Web.php';

    // product warehouse rooms routes

    require __DIR__ . '/../app/Modules/INVENTORY/Managements/WarehouseRoom/Routes/Web.php';

    // product warehouse room cartoon routes

    require __DIR__ . '/../app/Modules/INVENTORY/Managements/RoomCartoon/Routes/Web.php';

    // product supplier routes

    require __DIR__ . '/../app/Modules/INVENTORY/Managements/Suppliers/Routes/Web.php';

    // Supplier Source Type 

    require __DIR__ . '/../app/Modules/INVENTORY/Managements/SupplyerType/Routes/Web.php';

    // purchase product quotation routes
    require __DIR__ . '/../app/Modules/INVENTORY/Managements/Purchase/Quotations/Routes/Web.php';

    // purchase product order routes
    require __DIR__ . '/../app/Modules/INVENTORY/Managements/Purchase/Orders/Routes/Web.php';

    // purchase product other charge
    require __DIR__ . '/../app/Modules/INVENTORY/Managements/Purchase/ChargeTypes/Routes/Web.php';

    // generate report

    require __DIR__ . '/../app/Modules/INVENTORY/Managements/Report/Routes/Web.php';
});
