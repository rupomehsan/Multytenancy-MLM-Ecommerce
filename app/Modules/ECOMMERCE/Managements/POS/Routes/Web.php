<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\POS\Controllers\InvoiceController;
use App\Modules\ECOMMERCE\Managements\POS\Controllers\PosController;

Route::get('/pos/invoice/print/{id}', [InvoiceController::class, 'posInvoicePrint'])->name('POSInvoicePrint');
Route::get('/pos/invoice/content/{id}', [InvoiceController::class, 'getPrintableContent'])->name('POSInvoiceContent');
Route::get('/view/all/invoices', [InvoiceController::class, 'index'])->name('ViewAllInvoices');
Route::get('/invoice/show/{id}', [InvoiceController::class, 'showInvoice'])->name('ShowInvoice');
Route::get('/invoice/print/{id}', [InvoiceController::class, 'printInvoice'])->name('PrintInvoice');
Route::post('/invoice/generate/{id}', [InvoiceController::class, 'generateInvoice'])->name('GenerateInvoice');
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
Route::post('change/delivery/method', [PosController::class, 'changeDeliveryMethod'])->name('AdminChangeDeliveryMethod');
Route::post('pos/place/order', [PosController::class, 'placeOrder'])->name('PosPlaceOrder');
// Route::get('/edit/place/order/{slug}', [PosController::class, 'editPlaceOrder'])->name('EditPlaceOrder');
// Route::post('/update/place/order', [PosController::class, 'updatePlaceOrder'])->name('UpdatePlaceOrder');
