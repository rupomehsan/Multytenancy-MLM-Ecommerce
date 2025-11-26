<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralInfoController;

Route::group(['middleware' => ['auth', 'CheckUserType', 'DemoMode']], function () {

    // general info routes
    require __DIR__ . '/../app/Modules/ECOMMERCE/Managements/WebsiteConfigurations/Routes/Web.php';
});
