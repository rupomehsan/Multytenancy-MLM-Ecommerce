<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\PushNotification\Controllers\NotificationController;


Route::get('/send/notification/page', [NotificationController::class, 'sendNotificationPage'])->name('SendNotificationPage');
Route::get('/view/all/notifications', [NotificationController::class, 'ViewAllPushNotifications'])->name('ViewAllPushNotifications');
Route::get('/delete/notification/{id}', [NotificationController::class, 'deleteNotification'])->name('DeleteNotification');
Route::get('/delete/notification/with/range', [NotificationController::class, 'deleteNotificationRangeWise'])->name('DeleteNotificationRangeWise');
Route::post('/send/push/notification', [NotificationController::class, 'sendPushNotification'])->name('SendPushNotification');
