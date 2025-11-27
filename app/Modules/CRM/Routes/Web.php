<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CRM Module Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for the CRM module. These
|
*/

Route::group(['middleware' => ['auth', 'CheckUserType', 'DemoMode']], function () {

    require __DIR__ . '/../Managements/ContactHistory/Routes/Web.php';
    require __DIR__ . '/../Managements/ContactRequest/Routes/Web.php';
    require __DIR__ . '/../Managements/CustomerCategory/Routes/Web.php';
    require __DIR__ . '/../Managements/Customers/Routes/Web.php';
    require __DIR__ . '/../Managements/CustomerSourceType/Routes/Web.php';
    require __DIR__ . '/../Managements/NextDateContacts/Routes/Web.php';
    require __DIR__ . '/../Managements/EcommerceCustomers/Routes/Web.php';
    require __DIR__ . '/../Managements/SubscribedUsers/Routes/Web.php';
    require __DIR__ . '/../Managements/SupportTickets/Routes/Web.php';
});
