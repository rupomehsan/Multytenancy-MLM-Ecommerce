<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\POS\Controllers\PosController;
use App\Http\Controllers\Tenant\Admin\HomeController;
use App\Http\Controllers\ProductSizeValueController;
use App\Http\Controllers\SystemController;



Route::group(['middleware' => ['auth', 'CheckUserType', 'DemoMode']], function () {
    //Dashboard routes
    Route::get('/home', [HomeController::class, 'index'])->name('home');
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
    // pos routes
    Route::get('/create/new/order', [PosController::class, 'createNewOrder'])->name('CreateNewOrder');
    Route::post('/product/live/search', [PosController::class, 'productLiveSearch'])->name('ProductLiveSearch');
    Route::post('/get/pos/product/variants', [PosController::class, 'getProductVariantsPos'])->name('GetProductVariantsPos');
    Route::post('/check/pos/product/variant', [PosController::class, 'checkProductVariant'])->name('CheckProductVariant');
    Route::post('/add/to/cart', [PosController::class, 'addToCart'])->name('AddToCart');
    Route::get('/remove/cart/item/{index}', [PosController::class, 'removeCartItem'])->name('RemoveCartItem');
    Route::get('/update/cart/item/{index}/{qty}', [PosController::class, 'updateCartItem'])->name('UpdateCartItem');
    Route::get('/update/cart/discount/{index}/{discount}', [PosController::class, 'updateCartItemDiscount'])->name('UpdateCartItemDiscount');
    Route::post('/save/new/customer', [PosController::class, 'saveNewCustomer'])->name('SaveNewCustomer');
    Route::get('/update/order/total/{shipping_charge}/{discount}', [PosController::class, 'updateOrderTotal'])->name('UpdateOrderTotal');
    Route::post('/apply/coupon', [PosController::class, 'applyCoupon'])->name('ApplyCoupon');
    Route::post('/remove/coupon', [PosController::class, 'removeCoupon'])->name('RemoveCoupon');
    Route::post('district/wise/thana', [PosController::class, 'districtWiseThana'])->name('DistrictWiseThana');
    Route::post('district/wise/thana/by/name', [PosController::class, 'districtWiseThanaByName'])->name('DistrictWiseThanaByName');
    Route::post('save/pos/customer/address', [PosController::class, 'saveCustomerAddress'])->name('SaveCustomerAddress');
    Route::get('get/saved/address/{user_id}', [PosController::class, 'getSavedAddress'])->name('GetSavedAddress');
    Route::post('change/delivery/method', [PosController::class, 'changeDeliveryMethod'])->name('ChangeDeliveryMethod');
    Route::post('place/order', [PosController::class, 'placeOrder'])->name('PlaceOrder');
    // Route::get('/edit/place/order/{slug}', [PosController::class, 'editPlaceOrder'])->name('EditPlaceOrder');
    // Route::post('/update/place/order', [PosController::class, 'updatePlaceOrder'])->name('UpdatePlaceOrder');

    // POS Invoice Print Route
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
    // system routes for email config
    Route::get('/view/email/credential', [SystemController::class, 'viewEmailCredentials'])->name('ViewEmailCredentials');
    Route::get('/view/email/templates', [SystemController::class, 'viewEmailTemplates'])->name('ViewEmailTemplates');
    Route::get('/change/mail/template/status/{templateId}', [SystemController::class, 'changeMailTemplateStatus'])->name('ChangeMailTemplateStatus');
    Route::post('/save/new/email/configure', [SystemController::class, 'saveEmailCredential'])->name('SaveEmailCredential');
    Route::get('/delete/email/config/{slug}', [SystemController::class, 'deleteEmailCredential'])->name('DeleteEmailCredential');
    Route::get('/get/email/config/info/{slug}', [SystemController::class, 'getEmailCredentialInfo'])->name('GetEmailCredentialInfo');
    Route::post('/update/email/config', [SystemController::class, 'updateEmailCredentialInfo'])->name('UpdateEmailCredentialInfo');
    // system route for sms gateway
    Route::get('/setup/sms/gateways', [SystemController::class, 'viewSmsGateways'])->name('ViewSmsGateways');
    Route::post('/update/sms/gateway/info', [SystemController::class, 'updateSmsGatewayInfo'])->name('UpdateSmsGatewayInfo');
    Route::get('/change/gateway/status/{provider}', [SystemController::class, 'changeGatewayStatus'])->name('ChangeGatewayStatus');
    // system route for payment gateway
    Route::get('/setup/payment/gateways', [SystemController::class, 'viewPaymentGateways'])->name('ViewPaymentGateways');
    Route::post('/update/payment/gateway/info', [SystemController::class, 'updatePaymentGatewayInfo'])->name('UpdatePaymentGatewayInfo');
    Route::get('/change/payment/gateway/status/{provider}', [SystemController::class, 'changePaymentGatewayStatus'])->name('ChangePaymentGatewayStatus');


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


    // // Product Color Management
    // Route::get('/add/new/product-color', [ProductColorController::class, 'addNewProductColor'])->name('AddNewProductColor');
    // Route::post('/save/new/product-color', [ProductColorController::class, 'saveNewProductColor'])->name('SaveNewProductColor');
    // Route::get('/view/all/product-color', [ProductColorController::class, 'viewAllProductColor'])->name('ViewAllProductColor');
    // Route::get('/delete/product-color/{slug}', [ProductColorController::class, 'deleteProductColor'])->name('DeleteProductColor');
    // Route::get('/edit/product-color/{slug}', [ProductColorController::class, 'editProductColor'])->name('EditProductColor');
    // Route::post('/update/product-color', [ProductColorController::class, 'updateProductColor'])->name('UpdateProductColor');
    // // Product Size Management
    // Route::get('/add/new/product-size', [ProductSizeController::class, 'addNewProductSize'])->name('AddNewProductSize');
    // Route::post('/save/new/product-size', [ProductSizeController::class, 'saveNewProductSize'])->name('SaveNewProductSize');
    // Route::get('/view/all/product-size', [ProductSizeController::class, 'viewAllProductSize'])->name('ViewAllProductSize');
    // Route::get('/delete/product-size/{slug}', [ProductSizeController::class, 'deleteProductSize'])->name('DeleteProductSize');
    // Route::get('/edit/product-size/{slug}', [ProductSizeController::class, 'editProductSize'])->name('EditProductSize');
    // Route::post('/update/product-size', [ProductSizeController::class, 'updateProductSize'])->name('UpdateProductSize');
});
