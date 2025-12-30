<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\POS\Controllers\PosController;
use App\Http\Controllers\Tenant\Admin\HomeController;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Controllers\ProductSizeValueController;
use App\Modules\ECOMMERCE\Managements\EmailService\Controllers\SystemController;




//Dashboard routes
Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
Route::get('/crm-home', [HomeController::class, 'crm_index'])->name('crm.home');
Route::get('/accounts-home', [HomeController::class, 'accounts_index'])->name('accounts.home');
Route::get('/inventory-home', [HomeController::class, 'inventory_dashboard'])->name('inventory.home');
// customers and system users routes
require __DIR__ . '/../Managements/UserManagements/Users/Routes/Web.php';
// user role permission routes
require __DIR__ . '/../Managements/UserManagements/Roles/Routes/Web.php';
// configuration routes
require __DIR__ . '/../Managements/Configurations/Routes/Web.php';
// brand
require __DIR__ . '/../Managements/ProductManagements/ProductAttributes/Brands/Routes/Web.php';
// model
require __DIR__ . '/../Managements/ProductManagements/ProductAttributes/Models/Routes/Web.php';
// config routes for falg
require __DIR__ . '/../Managements/ProductManagements/ProductAttributes/Flags/Routes/Web.php';
// config routes for unit
require __DIR__ . '/../Managements/ProductManagements/ProductAttributes/Units/Routes/Web.php';
// colors
require __DIR__ . '/../Managements/ProductManagements/ProductAttributes/Colors/Routes/Web.php';
// config routes for sizes
require __DIR__ . '/../Managements/ProductManagements/ProductAttributes/Sizes/Routes/Web.php';
// category routes
require __DIR__ . '/../Managements/ProductManagements/Categories/Routes/Web.php';
// subcategory routes
require __DIR__ . '/../Managements/ProductManagements/SubCategories/Routes/Web.php';
// childcategory routes
require __DIR__ . '/../Managements/ProductManagements/ChildCategories/Routes/Web.php';
// package product routes
require __DIR__ . '/../Managements/ProductManagements/PackageProducts/Routes/Web.php';
// product routes
require __DIR__ . '/../Managements/ProductManagements/Products/Routes/Web.php';

// Product Size Value Management
Route::get('/add/new/product-size-value', [ProductSizeValueController::class, 'addNewProductSizeValue'])->name('AddNewProductSizeValue');
Route::post('/save/new/product-size-value', [ProductSizeValueController::class, 'saveNewProductSizeValue'])->name('SaveNewProductSizeValue');
Route::get('/view/all/product-size-value', [ProductSizeValueController::class, 'viewAllProductSizeValue'])->name('ViewAllProductSizeValue');
Route::get('/delete/product-size-value/{slug}', [ProductSizeValueController::class, 'deleteProductSizeValue'])->name('DeleteProductSizeValue');
Route::get('/edit/product-size-value/{slug}', [ProductSizeValueController::class, 'editProductSizeValue'])->name('EditProductSizeValue');
Route::post('/update/product-size-value', [ProductSizeValueController::class, 'updateProductSizeValue'])->name('UpdateProductSizeValue');
// order routes
require __DIR__ . '/../Managements/Orders/Routes/Web.php';
// payment history routes
require __DIR__ . '/../Managements/PaymentHistory/Routes/Web.php';
// POS   Route
require __DIR__ . '/../Managements/POS/Routes/Web.php';
// promo codes
require __DIR__ . '/../Managements/PromoCodes/Routes/Web.php';
// wishlist routes
require __DIR__ . '/../Managements/CutomerWistList/Routes/Web.php';
// push notification
require __DIR__ . '/../Managements/PushNotification/Routes/Web.php';
// delivery charges
require __DIR__ . '/../Managements/DeliveryCharges/Routes/Web.php';
// generate report
require __DIR__ . '/../Managements/Reports/Routes/Web.php';
// general info routes
require __DIR__ . '/../Managements/WebsiteConfigurations/Routes/Web.php';


// sliders and banners routes
require __DIR__ . '/../Managements/WebSiteContentManagement/Banners/Routes/Web.php';
// SideBanner Management
require __DIR__ . '/../Managements/WebSiteContentManagement/SideBanner/Routes/Web.php';
// testimonial routes
require __DIR__ . '/../Managements/WebSiteContentManagement/Testimonials/Routes/Web.php';
// blog category routes
require __DIR__ . '/../Managements/WebSiteContentManagement/BlogManagements/BlogCategory/Routes/Web.php';
// blog routes
require __DIR__ . '/../Managements/WebSiteContentManagement/BlogManagements/Blogs/Routes/Web.php';
// terms and policies routes
require __DIR__ . '/../Managements/WebSiteContentManagement/TermsAndPolicies/Routes/Web.php';
// custom page
require __DIR__ . '/../Managements/WebSiteContentManagement/CustomPages/Routes/Web.php';
// Outlets
require __DIR__ . '/../Managements/WebSiteContentManagement/Outlets/Routes/Web.php';
// Video Gallery
require __DIR__ . '/../Managements/WebSiteContentManagement/Videos/Routes/Web.php';

// faq routes
require __DIR__ . '/../Managements/WebSiteContentManagement/FAQ/Routes/Web.php';
