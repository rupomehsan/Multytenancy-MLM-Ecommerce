<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\CutomerWistList\Controllers\WishListController;

// auth routes
Route::get('/view/customers/wishlist', [WishListController::class, 'customersWishlist'])->name('CustomersWishlist');
