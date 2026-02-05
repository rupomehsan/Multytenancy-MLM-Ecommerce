<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SupportController;
use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\BlogController;


/*
|--------------------------------------------------------------------------
| ECOMMERCE MODULE WEB ROUTES
|--------------------------------------------------------------------------
| Loads the ECOMMERCE module routes (product listing, cart,
| checkout, product details and storefront endpoints).
*/

require __DIR__ . '/../app/Modules/INVENTORY/Routes/Api.php';


Route::group(['namespace' => 'Api'], function () {

    // Referral code validation endpoint
    Route::get('validate-referral', function (\Illuminate\Http\Request $request) {
        $code = $request->get('code');

        if (!$code) {
            return response()->json(['valid' => false, 'message' => 'Referral code is required']);
        }

        $exists = \App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User::where('referral_code', $code)
            ->where('user_type', 3) // Only customer referrals
            ->exists();

        return response()->json([
            'valid' => $exists,
            'message' => $exists ? 'Valid referral code' : 'Invalid referral code'
        ]);
    })->name('api.validate.referral');

    // authentication api | middleware(['throttle:5,1']) means 5 requests can be made in 1 minute
    Route::post('user/registration', [AuthenticationController::class, 'userRegistration'])->name('api.user.registration'); //->middleware(['throttle:5,1']);
    Route::post('user/verification', [AuthenticationController::class, 'userVerification'])->name('api.user.verification');
    Route::post('user/login', [AuthenticationController::class, 'userLogin'])->name('api.user.login');
    Route::post('forget/password', [AuthenticationController::class, 'forgetPassword'])->name('api.forget.password'); // forget password api
    Route::post('verify/reset/code', [AuthenticationController::class, 'verifyResetCode'])->name('api.verify.reset.code'); // forget password api
    Route::post('change/password', [AuthenticationController::class, 'changePassword'])->name('api.change.password'); // forget password api

    // available social login credentials
    Route::post('social/login/credentials', [AuthenticationController::class, 'socialLoginCredentials'])->name('api.social.login.credentials');
    Route::post('social/login', [AuthenticationController::class, 'socialLogin'])->name('api.social.login');


    Route::post('subscribe/for/updates', [ApiController::class, 'subscriptionForUpdates'])->name('api.subscribe.updates');
    Route::post('upload/profile/photo', [ProfileController::class, 'uploadProfilePhoto'])->name('api.upload.profile.photo');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user/profile/info', [ApiController::class, 'userProfileInfo'])->name('api.user.profile.info');
        Route::post('user/profile/update', [ApiController::class, 'userProfileUpdate'])->name('api.user.profile.update'); //for app only

        Route::post('user/profile/update/web', [ProfileController::class, 'userProfileUpdateWeb'])->name('api.user.profile.update.web'); //for web only
        Route::post('user/change/password/web', [ProfileController::class, 'userChangePasswordWeb'])->name('api.user.change.password.web'); //for web only
        Route::get('send/account/delete/request', [ProfileController::class, 'sendAccountDeleteRequest'])->name('api.send.account.delete.request');

        // user payment card api
        Route::post('add/new/card', [ProfileController::class, 'addNewCard'])->name('api.add.new.card');
        Route::get('get/my/cards', [ProfileController::class, 'getMyCards'])->name('api.get.my.cards');
        Route::post('update/my/card', [ProfileController::class, 'updateMyCard'])->name('api.update.my.card');
        Route::post('delete/my/card', [ProfileController::class, 'deleteMyCard'])->name('api.delete.my.card');

        // user multiple address api
        Route::post('add/new/address', [ProfileController::class, 'addNewAddress'])->name('api.add.new.address');
        Route::get('get/all/address', [ProfileController::class, 'getAllAddress'])->name('api.get.all.address');
        Route::post('update/my/address', [ProfileController::class, 'updateMyAddress'])->name('api.update.my.address');
        Route::post('delete/my/address', [ProfileController::class, 'deleteMyAddress'])->name('api.delete.my.address');

        // product review submit
        Route::post('product/review/submit', [ApiController::class, 'submitProductReview'])->name('api.product.review.submit');
    });
    Route::post('product/question/submit', [ApiController::class, 'submitProductQuestion'])->name('api.product.question.submit');

    Route::get('get/category/tree', [ApiController::class, 'getCategoryTree'])->name('api.get.category.tree');
    Route::get('category/list', [ApiController::class, 'getCategoryList'])->name('api.category.list');
    Route::get('get/featured/subcategories', [ApiController::class, 'getFeaturedSubcategory'])->name('api.get.featured.subcategories');
    Route::post('subcategory/of/category', [ApiController::class, 'getSubcategoryOfCategory'])->name('api.subcategory.of.category');
    Route::post('childcategory/of/subcategory', [ApiController::class, 'getChildcategoryOfSubcategory'])->name('api.childcategory.of.subcategory');
    Route::get('get/all/products', [ApiController::class, 'getAllProducts'])->name('api.get.all.products');
    Route::post('get/related/products', [ApiController::class, 'getRelatedProducts'])->name('api.get.related.products');
    Route::post('get/you/may/like/products', [ApiController::class, 'getYouMayLikeProducts'])->name('api.get.you.may.like.products');
    Route::post('category/wise/products', [ApiController::class, 'categoryWiseProducts'])->name('api.category.wise.products');
    Route::post('subcategory/wise/products', [ApiController::class, 'subcategoryWiseProducts'])->name('api.subcategory.wise.products');
    Route::post('childcategory/wise/products', [ApiController::class, 'childcategoryWiseProducts'])->name('api.childcategory.wise.products');
    Route::get('product/details/{id}', [ApiController::class, 'productDetails'])->name('api.product.details');
    Route::post('flag/wise/products', [ApiController::class, 'flagWiseProducts'])->name('api.flag.wise.products');
    Route::get('featured/flag/wise/products', [ApiController::class, 'featuredFlagWiseProducts'])->name('api.featured.flag.wise.products');
    Route::post('flag/wise/all/products', [ApiController::class, 'flagWiseAllProducts'])->name('api.flag.wise.all.products');
    Route::get('featured/brand/wise/products', [ApiController::class, 'featuredBrandWiseProducts'])->name('api.featured.brand.wise.products');
    Route::get('get/all/flags', [ApiController::class, 'getAllFlags'])->name('api.get.all.flags');
    Route::get('get/all/brands', [ApiController::class, 'getAllBrands'])->name('api.get.all.brands');
    Route::post('search/products', [ApiController::class, 'searchProducts'])->name('api.search.products');
    Route::get('search/products', [ApiController::class, 'searchProductsGet'])->name('api.search.products.get');
    Route::post('live/search/products', [ApiController::class, 'searchLiveProducts'])->name('api.live.search.products');
    Route::get('get/terms/and/condition', [ApiController::class, 'termsAndCondition'])->name('api.get.terms.and.condition');
    Route::get('get/privacy/policy', [ApiController::class, 'privacyPolicy'])->name('api.get.privacy.policy');
    Route::get('get/shipping/policy', [ApiController::class, 'shippingPolicy'])->name('api.get.shipping.policy');
    Route::get('get/return/policy', [ApiController::class, 'returnPolicy'])->name('api.get.return.policy');
    Route::get('get/about/us', [ApiController::class, 'aboutUs'])->name('api.get.about.us');
    Route::get('get/all/faq', [ApiController::class, 'getAllFaq'])->name('api.get.all.faq');
    Route::get('general/info', [ApiController::class, 'generalInfo'])->name('api.general.info');
    Route::get('get/all/sliders', [ApiController::class, 'getAllSliders'])->name('api.get.all.sliders');
    Route::get('get/all/banners', [ApiController::class, 'getAllBanners'])->name('api.get.all.banners');
    Route::get('get/promotional/banner', [ApiController::class, 'getPromotionalBanner'])->name('api.get.promotional.banner');
    Route::post('submit/contact/us/request', [ApiController::class, 'submitContactRequest'])->name('api.submit.contact.us.request');
    Route::get('get/all/testimonials', [ApiController::class, 'getAllTestimonials'])->name('api.get.all.testimonials');
    Route::get('get/payment/gateways', [ApiController::class, 'getPaymentGateways'])->name('api.get.payment.gateways');
    Route::post('order/preview', [ApiController::class, 'orderPreview'])->name('api.order.preview');
    Route::get('get/delivery/charge/{district}', [ApiController::class, 'getdeliveryCharge'])->name('api.get.delivery.charge');

    // new api for districts and thana
    Route::get('get/all/districts', [ApiController::class, 'getAllDistricts'])->name('api.get.all.districts');
    Route::post('district/wise/thana', [ApiController::class, 'getDistrictWiseThana'])->name('api.district.wise.thana');
    Route::get('get/districts/with/thana', [ApiController::class, 'getDistrictsWithThana'])->name('api.get.districts.with.thana');


    // unique api
    Route::get('best/selling/product', [ApiController::class, 'bestSellingProduct'])->name('api.best.selling.product');
    Route::get('products/for/you/with/login', [ApiController::class, 'productsForYouLoggedIn'])->middleware('auth:sanctum')->name('api.products.for.you.with.login');
    Route::get('products/for/you', [ApiController::class, 'productsForYou'])->name('api.products.for.you');


    // order api start
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('order/checkout', [ApiController::class, 'orderCheckout'])->name('api.order.checkout');
        Route::post('order/checkout/app/only', [ApiController::class, 'orderCheckoutAppOnly'])->name('api.order.checkout.app.only');
        Route::get('get/my/orders', [ApiController::class, 'getMyOrders'])->name('api.get.my.orders');
        Route::get('order/details/{slug}', [ApiController::class, 'orderDetails'])->name('api.order.details');
    });
    Route::post('order/progress', [ApiController::class, 'orderProgress'])->name('api.order.progress');
    Route::post('guest/order/checkout', [ApiController::class, 'guestOrderCheckout'])->name('api.guest.order.checkout'); // for guest
    Route::post('submit/shipping/billing/info', [ApiController::class, 'shippingBillingInfo'])->name('api.submit.shipping.billing.info');
    Route::post('order/payment/cod', [ApiController::class, 'orderCashOnDelivery'])->name('api.order.payment.cod');
    // order api end


    // cart & checkout api for app only start
    Route::post('add/to/cart', [CartController::class, 'addToCart'])->name('api.add.to.cart');
    Route::post('incr/cart/qty', [CartController::class, 'incrCartQty'])->name('api.incr.cart.qty');
    Route::post('decr/cart/qty', [CartController::class, 'decrCartQty'])->name('api.decr.cart.qty');
    Route::post('delete/cart/item', [CartController::class, 'deleteCartItem'])->name('api.delete.cart.item');
    Route::post('get/cart/items', [CartController::class, 'getCartItems'])->name('api.get.cart.items');

    Route::get('get/all/coupons', [CartController::class, 'getAllCoupons'])->name('api.get.all.coupons');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('apply/coupon', [CartController::class, 'applyCoupon'])->name('api.apply.coupon');
        Route::post('order/cart/checkout', [CartController::class, 'cartCheckout'])->name('api.order.cart.checkout');
        Route::post('order/checkout/buy/now/app', [CartController::class, 'checkoutBuyNow'])->name('api.order.checkout.buy.now.app'); // for app only

        // wishlists
        Route::post('add/to/wishlist', [CartController::class, 'addToWishList'])->name('api.add.to.wishlist');
        Route::get('get/my/wishlist', [CartController::class, 'getMyWishList'])->name('api.get.my.wishlist');
        Route::post('delete/my/wishlist', [CartController::class, 'deleteMyWishList'])->name('api.delete.my.wishlist');
    });
    Route::post('guest/order/checkout/buy/now/app', [CartController::class, 'guestCartCheckoutBuyNow'])->name('api.guest.order.checkout.buy.now.app');
    Route::post('guest/order/cart/checkout', [CartController::class, 'guestCartCheckout'])->name('api.guest.order.cart.checkout');
    // cart & checkout api for app only end


    // support ticket api routes
    Route::post('upload/support/ticket/file', [SupportController::class, 'uploadSupportTicketFile'])->name('api.upload.support.ticket.file');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('submit/support/ticket', [SupportController::class, 'submitSupportTicket'])->name('api.submit.support.ticket');
        Route::post('send/support/ticket/message', [SupportController::class, 'sendSupportTicketMessage'])->name('api.send.support.ticket.message');
        Route::get('get/all/support/tickets', [SupportController::class, 'getAllSupportTickets'])->name('api.get.all.support.tickets');
        Route::post('get/all/support/ticket/messages', [SupportController::class, 'getAllSupportTicketMessages'])->name('api.get.all.support.ticket.messages');
    });


    // filter api
    Route::post('/filter/search/results', [FilterController::class, 'filterSearchResults'])->name('api.filter.search.results');
    Route::post('/filter/products', [FilterController::class, 'filterProducts'])->name('api.filter.products');

    // filter criteria api
    Route::get('get/all/storages', [FilterController::class, 'getAllStorages'])->name('api.get.all.storages');
    Route::get('get/all/sims', [FilterController::class, 'getAllSims'])->name('api.get.all.sims');
    Route::get('get/all/device/conditions', [FilterController::class, 'getAllDeviceConditions'])->name('api.get.all.device.conditions');
    Route::get('get/all/warrenty/types', [FilterController::class, 'getAllWarrentyTypes'])->name('api.get.all.warrenty.types');
    Route::get('get/all/regions', [FilterController::class, 'getAllRegions'])->name('api.get.all.regions');

    // blog api
    Route::get('get/all/blog/categories', [BlogController::class, 'getAllBlogCategories'])->name('api.get.all.blog.categories');
    Route::get('get/all/blogs', [BlogController::class, 'getAllBlogs'])->name('api.get.all.blogs');
    Route::post('get/category/wise/blogs', [BlogController::class, 'getCategoryWiseBlogs'])->name('api.get.category.wise.blogs');
    Route::get('blog/details/{slug}', [BlogController::class, 'blogDetails'])->name('api.blog.details');
});
