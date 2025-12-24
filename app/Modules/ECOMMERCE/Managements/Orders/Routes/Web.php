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
Route::get('/view/return/orders', [OrderController::class, 'viewReturnOrders'])->name('ViewReturnOrders');
Route::get('/view/intransit/orders', [OrderController::class, 'viewIntransitOrders'])->name('ViewIntransitOrders');
Route::get('/view/dispatch/orders', [OrderController::class, 'viewAllDispatchOrders'])->name('viewDispatchOrders');
Route::get('/admin/order/details/{slug}', [OrderController::class, 'orderDetails'])->name('adminOrderDetails');
Route::get('/admin/cancel/order/{slug}', [OrderController::class, 'cancelOrder'])->name('CancelOrder');
Route::get('/admin/approve/order/{slug}', [OrderController::class, 'approveOrder'])->name('ApproveOrder');
Route::get('/admin/intransit/order/{slug}', [OrderController::class, 'intransitOrder'])->name('IntransitOrder');
Route::get('/admin/deliver/order/{slug}', [OrderController::class, 'deliverOrder'])->name('DeliverOrder');
Route::post('/order/info/update', [OrderController::class, 'orderInfoUpdate'])->name('OrderInfoUpdate');
Route::get('/admin/order/edit/{slug}', [OrderController::class, 'orderEdit'])->name('OrderEdit');
Route::post('/order/update', [OrderController::class, 'orderUpdate'])->name('OrderUpdate');
Route::post('/add/more/product', [OrderController::class, 'addMoreProduct'])->name('AddMoreProduct');
Route::post('/get/product/variants', [OrderController::class, 'getProductVariants'])->name('GetProductVariants');
Route::get('delete/order/{slug}', [OrderController::class, 'deleteOrder'])->name('DeleteOrder');
Route::get('view/orders/log', [OrderController::class, 'viewOrderLogs'])->name('ViewOrderLogs');
Route::get('view/order/log/details/{id}', [OrderController::class, 'viewOrderLogDetails'])->name('ViewOrderLogDetails');
