<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Brian2694\Toastr\Facades\Toastr;
/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
| Handles user authentication: login, registration, password resets
| and other auth-related endpoints.
*/

Route::get('admin/login', [\App\Http\Controllers\Tenant\Admin\Auth\LoginController::class, 'showLoginForm'])->name('admin.login')->middleware('guest:admin');
Route::post('admin/login', [\App\Http\Controllers\Tenant\Admin\Auth\LoginController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [\App\Http\Controllers\Tenant\Admin\Auth\LoginController::class, 'logout'])->name('admin.logout');

Route::group(['middleware' => ['auth:admin', 'CheckUserType', 'DemoMode']], function () {

    // Custom auth routes pointing to tenant frontend auth controllers
    // Login / Logout
    // Route::middleware([CheckUserType::class, DemoMode::class])->group(function () {
    //     Route::get('/change/password/page', [HomeController::class, 'changePasswordPage'])->name('changePasswordPage');
    //     Route::post('/change/password', [HomeController::class, 'changePassword'])->name('changePassword');
    //     Route::get('ckeditor', [CkeditorController::class, 'index']);
    //     Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('ckeditor.upload');
    // });

    /*

|--------------------------------------------------------------------------
| ECOMMERCE MODULE WEB ROUTES
|--------------------------------------------------------------------------
| Loads the ECOMMERCE module routes (product listing, cart,
| checkout, product details and storefront endpoints).
*/

    require __DIR__ . '/../app/Modules/ECOMMERCE/Routes/Web.php';

    /*
|--------------------------------------------------------------------------
| INVENTORY MODULE WEB ROUTES
|--------------------------------------------------------------------------
| Loads inventory management routes (stock, warehouses,
| product variants and inventory operations).
*/

    require __DIR__ . '/../app/Modules/INVENTORY/Routes/Web.php';

    /*
|--------------------------------------------------------------------------
| CRM MODULE WEB ROUTES
|--------------------------------------------------------------------------
| Loads CRM module routes (customers, leads, contacts,
| and related CRM functionality).
*/

    require __DIR__ . '/../app/Modules/CRM/Routes/Web.php';


    /*
|--------------------------------------------------------------------------
| ACCOUNTS MODULE ROUTES
|--------------------------------------------------------------------------
| Loads accounting-related routes (vouchers, transactions,
| reports and account management endpoints).
*/

    require __DIR__ . '/../app/Modules/ACCOUNTS/Routes/Web.php';

    /*
|--------------------------------------------------------------------------
| MLM MODULE ROUTES
|--------------------------------------------------------------------------
| Loads MLM module routes (network, commissions,
| agent management and related endpoints).
*/

    require_once __DIR__ . '/../app/Modules/MLM/Routes/Web.php';

    /*
|--------------------------------------------------------------------------
| PAYMENT ROUTES
|--------------------------------------------------------------------------
| Payment gateway callbacks, checkout processing and
| payment-related webhooks and endpoints.
*/


    require __DIR__ . '/paymentRoutes.php';

    /*
|--------------------------------------------------------------------------
| GENERAL ROUTES
|--------------------------------------------------------------------------
| Miscellaneous application routes: backups, SMS services,
| and other general-purpose endpoints.
*/

    require __DIR__ . '/generalRoutes.php';
});



/*
|--------------------------------------------------------------------------
| CLEAR CACHE ROUTES
|--------------------------------------------------------------------------
| Utility routes to view and clear application cache and
| other maintenance helpers (development use only).
*/
Route::get('/clear/cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Toastr::success('All cache cleared!', 'Success');
    return redirect()->back();
});
