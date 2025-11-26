<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\Orders\Controllers\OrderController;

// order routes
Route::get('/view/orders', [OrderController::class, 'viewAllOrders'])->name('ViewAllOrders');
Route::get('/view/trash/orders', [OrderController::class, 'viewAllTrashedOrders'])->name('viewAllTrashedOrders');
Route::get('/restore/orders/{slug}', [OrderController::class, 'RestoreOrder'])->name('RestoreOrder');
Route::get('/view/pending/orders', [OrderController::class, 'viewPendigOrders'])->name('ViewPendigOrders');
Route::get('/view/approved/orders', [OrderController::class, 'viewApprovedOrders'])->name('ViewApprovedOrders');
Route::get('/view/delivered/orders', [OrderController::class, 'viewDeliveredOrders'])->name('ViewDeliveredOrders');
Route::get('/view/cancelled/orders', [OrderController::class, 'viewCancelledOrders'])->name('ViewCancelledOrders');
Route::get('/view/picked/orders', [OrderController::class, 'viewPickedOrders'])->name('ViewPickedOrders');
Route::get('/view/intransit/orders', [OrderController::class, 'viewIntransitOrders'])->name('ViewIntransitOrders');
Route::get('/view/dispatch/orders', [OrderController::class, 'viewAllDispatchOrders'])->name('viewDispatchOrders');
Route::get('/order/details/{slug}', [OrderController::class, 'orderDetails'])->name('OrderDetails');
Route::get('/cancel/order/{slug}', [OrderController::class, 'cancelOrder'])->name('CancelOrder');
Route::get('/approve/order/{slug}', [OrderController::class, 'approveOrder'])->name('ApproveOrder');
Route::get('/intransit/order/{slug}', [OrderController::class, 'intransitOrder'])->name('IntransitOrder');
Route::get('/deliver/order/{slug}', [OrderController::class, 'deliverOrder'])->name('DeliverOrder');
Route::post('/order/info/update', [OrderController::class, 'orderInfoUpdate'])->name('OrderInfoUpdate');
Route::get('/order/edit/{slug}', [OrderController::class, 'orderEdit'])->name('OrderEdit');
Route::post('/order/update', [OrderController::class, 'orderUpdate'])->name('OrderUpdate');
Route::post('/add/more/product', [OrderController::class, 'addMoreProduct'])->name('AddMoreProduct');
Route::post('/get/product/variants', [OrderController::class, 'getProductVariants'])->name('GetProductVariants');
Route::get('delete/order/{slug}', [OrderController::class, 'deleteOrder'])->name('DeleteOrder');
