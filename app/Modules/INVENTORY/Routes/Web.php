
<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'CheckUserType', 'DemoMode']], function () {

    // product warehouse routes

    require __DIR__ . '/../Managements/WareHouse/Routes/Web.php';

    // product warehouse rooms routes

    require __DIR__ . '/../Managements/WareHouseRoom/Routes/Web.php';

    // product warehouse room cartoon routes

    require __DIR__ . '/../Managements/WareHouseRoomCartoon/Routes/Web.php';

    // product supplier routes

    require __DIR__ . '/../Managements/Suppliers/Routes/Web.php';

    // Supplier Source Type 

    require __DIR__ . '/../Managements/SupplierType/Routes/Web.php';

    // purchase product quotation routes
    require __DIR__ . '/../Managements/Purchase/Quotations/Routes/Web.php';

    // purchase product order routes
    require __DIR__ . '/../Managements/Purchase/Orders/Routes/Web.php';

    // purchase product other charge
    require __DIR__ . '/../Managements/Purchase/ChargeTypes/Routes/Web.php';

    // generate report

    require __DIR__ . '/../Managements/Report/Routes/Web.php';
});


?>