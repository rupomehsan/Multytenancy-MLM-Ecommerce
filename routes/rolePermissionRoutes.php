<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\PermissionRoutesController;


Route::group(['middleware' => ['auth', 'CheckUserType', 'DemoMode']], function () {

    // customers and system users routes
    require __DIR__ . '/../app/Modules/ECOMMERCE/Managements/UserManagements/Users/Routes/Web.php';
    // user role permission routes
    require __DIR__ . '/../app/Modules/ECOMMERCE/Managements/UserManagements/RolePermissions/Routes/rolePermissionRoutes.php';
});
