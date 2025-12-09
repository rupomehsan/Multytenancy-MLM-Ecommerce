<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Honeypot\ProtectAgainstSpam;


use App\Http\Controllers\Tenant\Frontend\FrontendController;
use App\Http\Controllers\Tenant\Frontend\BlogController;
use App\Http\Controllers\Tenant\Frontend\CartController;
use App\Http\Controllers\Tenant\Frontend\HomeController;
use App\Http\Controllers\Tenant\Frontend\FilterController;
use App\Http\Controllers\Tenant\Frontend\GoogleController;
use App\Http\Controllers\Tenant\Frontend\Auth\ForgotPasswordController;
use App\Http\Controllers\Tenant\Frontend\CheckoutController;
use App\Http\Controllers\Tenant\Frontend\DeliveryController;
use App\Http\Controllers\Tenant\Frontend\UserDashboardController;
use App\Http\Controllers\Tenant\Frontend\SupportTicketController;
use App\Http\Controllers\Tenant\Frontend\PaymentController;
use Illuminate\Http\Request;

use App\Http\Controllers\Tenant\Frontend\MlmController;



/*
|--------------------------------------------------------------------------
| TENANT AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
| Handles user : login, registration, password resets
| and other auth-related endpoints.
*/

// Custom auth routes pointing to tenant frontend auth controllers
// Login / Logout
Route::get('login', [\App\Http\Controllers\Tenant\Frontend\Auth\LoginController::class, 'showLoginForm'])->name('login')->middleware('guest:customer');
Route::post('login', [\App\Http\Controllers\Tenant\Frontend\Auth\LoginController::class, 'login'])->name('customer.login.post');
Route::post('logout', [\App\Http\Controllers\Tenant\Frontend\Auth\LoginController::class, 'logout'])->name('logout');

// Registration
Route::get('register', [\App\Http\Controllers\Tenant\Frontend\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [\App\Http\Controllers\Tenant\Frontend\Auth\RegisterController::class, 'register']);

// Password Reset
Route::get('password/reset', [\App\Http\Controllers\Tenant\Frontend\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [\App\Http\Controllers\Tenant\Frontend\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [\App\Http\Controllers\Tenant\Frontend\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [\App\Http\Controllers\Tenant\Frontend\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Password Confirmation
Route::get('password/confirm', [\App\Http\Controllers\Tenant\Frontend\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('password/confirm', [\App\Http\Controllers\Tenant\Frontend\Auth\ConfirmPasswordController::class, 'confirm']);

// Email Verification
Route::get('email/verify', [\App\Http\Controllers\Tenant\Frontend\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [\App\Http\Controllers\Tenant\Frontend\Auth\VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [\App\Http\Controllers\Tenant\Frontend\Auth\VerificationController::class, 'resend'])->name('verification.resend');

Route::get('/forget/password', [ForgotPasswordController::class, 'userForgetPassword'])->name('UserForgetPassword');

// forget password
// TODO: ForgetPasswordController doesn't exist - commented out temporarily
// Route::group(['middleware' => ['web']], function () { //wihout web middleware session will not work
//     Route::post('/send/forget/password/code', [ForgetPasswordController::class, 'sendForgetPasswordCode'])->name('SendForgetPasswordCode');
//     Route::get('/new/password', [ForgetPasswordController::class, 'newPasswordPage'])->name('NewPasswordPage');
//     Route::post('/change/forgotten/password', [ForgetPasswordController::class, 'changeForgetPassword'])->name('ChangeForgetPassword');
// });


/*
|--------------------------------------------------------------------------
| TENANT WEBSITE ROUTES
|--------------------------------------------------------------------------
| Handles user : frontend website routes
| and other frontend-related endpoints.
*/


Route::get('/', [FrontendController::class, 'index'])->name('Index');

Route::get('/load-flag-products', [FrontendController::class, 'loadFlagProducts']);


// Route::get('/track/order', [FrontendController::class, 'trackOrder'])->name('trackOrder');
Route::get('track/order/{order_no}', [FrontendController::class, 'trackOrder'])->name('TrackOrder');
Route::get('track/order', [FrontendController::class, 'trackOrderNo'])->name('TrackOrderNo');


Route::post('/redirect/for/tracking', [FrontendController::class, 'redirectForTracking'])->name('RedirectForTracking');
Route::get('/search/for/products', [FrontendController::class, 'searchForProducts'])->name('SearchForProducts');
Route::post('/fetch/more/products', [FrontendController::class, 'fetchMoreProducts'])->name('FetchMoreProducts');
Route::get('/shop', [FrontendController::class, 'shop'])->name('Shop');
Route::get('/packages', [FrontendController::class, 'packages'])->name('Packages');
Route::get('/product/details/{slug}', [FrontendController::class, 'productDetails'])->name('ProductDetails');
Route::get('/package/details/{slug}', [FrontendController::class, 'packageDetails'])->name('PackageDetails');
Route::post('check/product/variant', [FrontendController::class, 'checkProductVariant'])->name('CheckProductVariant');
Route::post('check/package/stock', [FrontendController::class, 'checkPackageStock'])->name('CheckPackageStock');
Route::post('check/product/stock', [FrontendController::class, 'checkProductStock'])->name('CheckProductStock');
Route::post('get/cart/status', [FrontendController::class, 'getCartStatus'])->name('GetCartStatus');
Route::post('filter/products', [FilterController::class, 'filterProducts'])->name('FilterProducts');
Route::post('filter/products/brand', [FilterController::class, 'filterProductsBrand'])->name('FilterProductsBrand');

// photo album
Route::get('/photo-album', [FrontendController::class, 'photo_album'])->name('PhotoAlbum');
// Route::get('/photo-album-cat-sub', [FrontendController::class, 'photo_album_cat_sub'])->name('PhotoAlbumCatSub');
Route::get('/outlet', [FrontendController::class, 'outlet'])->name('OutLet');
Route::get('/video-gallery', [FrontendController::class, 'video_gallery'])->name('VideoGallery');

Route::get('/about', [FrontendController::class, 'about'])->name('About');
Route::get('/faq', [FrontendController::class, 'faq'])->name('Faq');
Route::get('/contact', [FrontendController::class, 'contact'])->name('Contact');
Route::get('/custom-page/{slug}', [FrontendController::class, 'customPage'])->name('CustomPage');
Route::post('/submit/contact/request', [FrontendController::class, 'submitContactRequest'])->name('SubmitContactRequest')->middleware(ProtectAgainstSpam::class)->middleware(['throttle:3,1']);
Route::post('subscribe/for/newsletter', [FrontendController::class, 'subscribeForNewsletter'])->name('SubscribeForNewsletter')->middleware(ProtectAgainstSpam::class)->middleware(['throttle:3,1']);

// policy pages
Route::get('privacy/policy', [FrontendController::class, 'privacyPolicy'])->name('PrivacyPolicy');
Route::get('terms/of/services', [FrontendController::class, 'termsOfServices'])->name('TermsOfServices');
Route::get('refund/policy', [FrontendController::class, 'refundPolicy'])->name('RefundPolicy');
Route::get('shipping/policy', [FrontendController::class, 'shippingPolicy'])->name('ShippingPolicy');

// cart
Route::get('add/to/cart/{id}', [CartController::class, 'addToCart'])->name('AddToCart');
Route::post('add/to/cart/with/qty', [CartController::class, 'addToCartWithQty'])->name('AddToCartWithQty');
Route::get('remove/cart/item/{id}', [CartController::class, 'removeCartTtem'])->name('RemoveCartTtem');
Route::get('remove/cart/item/by/key/{cartKey}', [CartController::class, 'removeCartItemByKey'])->name('RemoveCartItemByKey');
Route::post('update/cart/qty', [CartController::class, 'updateCartQty'])->name('UpdateCartQty');

// blog routes
Route::get('/blogs', [BlogController::class, 'blogs'])->name('Blogs');
Route::get('/blog/details/{slug}', [BlogController::class, 'blogDetails'])->name('BlogDetails');
Route::get('category/wise/blogs/{id}', [BlogController::class, 'categoryWiseBlogs'])->name('CategoryWiseBlogs');
Route::get('search/blogs', [BlogController::class, 'searchBlogs'])->name('SearchBlogs');
Route::get('tag/wise/blogs/{tag}', [BlogController::class, 'tagWiseBlogs'])->name('TagWiseBlogs');



// social login
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('RedirectToGoogle');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('HandleGoogleCallback');


// ssl commerz payment routes
Route::get('sslcommerz/order', [PaymentController::class, 'order'])->name('payment.order');
Route::post('sslcommerz/success', [PaymentController::class, 'success'])->name('payment.success');
Route::post('sslcommerz/failure', [PaymentController::class, 'failure'])->name('sslc.failure');
Route::post('sslcommerz/cancel', [PaymentController::class, 'cancel'])->name('sslc.cancel');
Route::post('sslcommerz/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');
Route::post('payment/confirm', [PaymentController::class, 'paymentConfirm'])->name('payment.confirm');


// place order related routes
if (Schema::hasTable('general_infos')) {
    $guestOrderStatus = DB::table('general_infos')->select('guest_checkout')->where('id', 1)->first();
    if ($guestOrderStatus && $guestOrderStatus->guest_checkout == 1) {
        Route::get('checkout', [CheckoutController::class, 'checkout'])->name('Checkout')->middleware(['throttle:5000,5']);
        Route::post('apply/coupon', [CheckoutController::class, 'applyCoupon'])->name('ApplyCoupon');
        Route::post('remove/coupon', [CheckoutController::class, 'removeCoupon'])->name('RemoveCoupon');
        Route::post('district/wise/thana', [CheckoutController::class, 'districtWiseThana'])->name('DistrictWiseThana');
        Route::post('change/delivery/method', [CheckoutController::class, 'changeDeliveryMethod'])->name('ChangeDeliveryMethod');
        Route::post('place/order', [CheckoutController::class, 'placeOrder'])->name('PlaceOrder');
        Route::get('order/{slug}', [CheckoutController::class, 'orderPreview'])->name('OrderPreview');
    }
}



/*
|--------------------------------------------------------------------------
| TENANT CUSTOMER ROUTES
|--------------------------------------------------------------------------
| Handles user : customer authenticated routes
| and other customer-related endpoints.
*/

Route::middleware(['auth:customer'])->group(function () {

    Route::get('/user/verification', [HomeController::class, 'userVerification'])->name('UserVerification');
    Route::post('/user/verify/check', [HomeController::class, 'userVerifyCheck'])->name('UserVerifyCheck');
    Route::get('/user/verification/resend', [HomeController::class, 'userVerificationResend'])->name('UserVerificationResend');


    Route::group(['middleware' => ['CheckUserVerification']], function () {

        if (Schema::hasTable('general_infos')) {
            $guestOrderStatus = DB::table('general_infos')->select('guest_checkout')->where('id', 1)->first();
            if ($guestOrderStatus && $guestOrderStatus->guest_checkout == 0) {
                Route::get('checkout', [CheckoutController::class, 'checkout'])->name('Checkout')->middleware(['throttle:5,1']);
                Route::post('apply/coupon', [CheckoutController::class, 'applyCoupon'])->name('ApplyCoupon');
                Route::post('remove/coupon', [CheckoutController::class, 'removeCoupon'])->name('RemoveCoupon');
                Route::post('district/wise/thana', [CheckoutController::class, 'districtWiseThana'])->name('DistrictWiseThana');
                Route::post('change/delivery/method', [CheckoutController::class, 'changeDeliveryMethod'])->name('ChangeDeliveryMethod');
                Route::post('place/order', [CheckoutController::class, 'placeOrder'])->name('PlaceOrder');
                Route::get('order/{slug}', [CheckoutController::class, 'orderPreview'])->name('OrderPreview');
            }
        }

        Route::get('/customer/home', [HomeController::class, 'index'])->name('customer.home');
        //mlm routes 
        Route::get('/customer/mlm/referral-tree', [MlmController::class, 'referral_tree'])->name('customer.mlm.referral_tree');
        Route::get('/customer/mlm/referral-lists', [MlmController::class, 'referral_list'])->name('customer.mlm.referral_list');
        Route::get('/customer/mlm/commission-history', [MlmController::class, 'commission_history'])->name('customer.mlm.commission_history');
        Route::get('/customer/mlm/earning-reports', [MlmController::class, 'earning_reports'])->name('customer.mlm.earning_reports');
        Route::get('/customer/mlm/withdrawal-requests', [MlmController::class, 'withdrawal_requests'])->name('customer.mlm.withdrawal_requests');
        Route::post('/customer/mlm/submit-withdrawal-request', [MlmController::class, 'submit_withdrawal_request'])->name('customer.mlm.submit_withdrawal_request');
        //end mlm routes

        Route::post('submit/product/review', [HomeController::class, 'submitProductReview'])->name('SubmitProductReview');
        Route::post('submit/product-question', [HomeController::class, 'submitProductQuestion'])->name('SubmitProductQuestion');

        Route::get('add/to/wishlist/{slug}', [HomeController::class, 'addToWishlist'])->name('AddToWishlist');
        Route::get('remove/from/wishlist/{slug}', [HomeController::class, 'removeFromWishlist'])->name('removeFromWishlist');

        Route::get('/my/orders', [UserDashboardController::class, 'userDashboard'])->name('UserDashboard');
        Route::get('/order/details/{slug}', [UserDashboardController::class, 'orderDetails'])->name('OrderDetails');
        Route::get('/track/my/order/{order_no}', [UserDashboardController::class, 'trackMyOrder'])->name('TrackMyOrder');
        Route::get('/my/wishlists', [UserDashboardController::class, 'myWishlists'])->name('MyWishlists');
        Route::get('/my/payments', [UserDashboardController::class, 'myPayments'])->name('MyPayments');
        Route::get('/clear/all/wishlist', [UserDashboardController::class, 'clearAllWishlist'])->name('clearAllWishlist');
        Route::get('/promo/coupons', [UserDashboardController::class, 'promoCoupons'])->name('PromoCoupons');
        Route::get('/change/password', [UserDashboardController::class, 'changePassword'])->name('ChangePassword');
        Route::post('/update/password', [UserDashboardController::class, 'updatePassword'])->name('UpdatePassword');
        Route::get('/product/reviews', [UserDashboardController::class, 'productReviews'])->name('productReviews');
        Route::get('/delete/product/review/{id}', [UserDashboardController::class, 'deleteProductReview'])->name('DeleteProductReview');
        Route::post('/update/product/review', [UserDashboardController::class, 'updateProductReview'])->name('UpdateProductReview');
        Route::get('/manage/profile', [UserDashboardController::class, 'manageProfile'])->name('ManageProfile');
        Route::get('/remove/user/image', [UserDashboardController::class, 'removeUserImage'])->name('RemoveUserImage');
        Route::get('/unlink/google/account', [UserDashboardController::class, 'unlinkGoogleAccount'])->name('UnlinkGoogleAccount');
        Route::post('/update/profile', [UserDashboardController::class, 'updateProfile'])->name('UpdateProfile');
        Route::post('/send/otp/profile', [UserDashboardController::class, 'sendOtpProfile'])->name('SendOtpProfile');
        Route::post('/verify/sent/otp', [UserDashboardController::class, 'verifySentOtp'])->name('VerifySentOtp');
        Route::get('/user/address', [UserDashboardController::class, 'userAddress'])->name('UserAddress');
        Route::post('/save/user/address', [UserDashboardController::class, 'saveUserAddress'])->name('SaveUserAddress');
        Route::get('/remove/user/address/{slug}', [UserDashboardController::class, 'removeUserAddress'])->name('RemoveUserAddress');
        Route::post('/update/user/address', [UserDashboardController::class, 'updateUserAddress'])->name('UpdateUserAddress');
        Route::post('/toggle/default/address', [UserDashboardController::class, 'toggleDefaultAddress'])->name('ToggleDefaultAddress');

        Route::get('/support/tickets', [SupportTicketController::class, 'supportTickets'])->name('SupportTickets');
        Route::get('/create/ticket', [SupportTicketController::class, 'createTicket'])->name('createTicket');
        Route::post('/save/support/ticket', [SupportTicketController::class, 'saveSupportTicket'])->name('SaveSupportTicket');
        Route::get('/support/ticket/message/{slug}', [SupportTicketController::class, 'supportTicketMessage'])->name('SupportTicketMessage');
        Route::post('send/support/message', [SupportTicketController::class, 'sendSupportMessage'])->name('SendSupportMessage');

        Route::get('/my/delivery/orders', [DeliveryController::class, 'deliveryOrders'])->name('deliveryOrders');
        Route::post('/delivery/update-order-status', [DeliveryController::class, 'updateStatus'])->name('updateStatus');
        Route::POST('cancle/order/{slug}', [CheckoutController::class, 'cancelOrder'])->name('cancelOrder');
    });
});

/*
|--------------------------------------------------------------------------
| TENANT HELPER ROUTES
|--------------------------------------------------------------------------
| 
| 
*/

Route::post('/save-fcm-token', function (Request $request) {
    $request->validate(['token' => 'required|string']);
    DB::table('fcm_tokens')->updateOrInsert(
        ['token' => $request->token],
        ['created_at' => now()]
    );
    return response()->json(['success' => true]);
});
