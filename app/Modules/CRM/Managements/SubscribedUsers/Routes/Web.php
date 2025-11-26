<?php


use Illuminate\Support\Facades\Route;
use App\Modules\CRM\Managements\SubscribedUsers\Controllers\SubscribedUsersController;
/*
|--------------------------------------------------------------------------
| Subscribed Users Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for subscribed users management in the CRM module. These
|
*/

Route::get('/view/all/subscribed/users', [SubscribedUsersController::class, 'viewAllSubscribedUsers'])->name('ViewAllSubscribedUsers');
Route::get('/delete/subcribed/users/{id}', [SubscribedUsersController::class, 'deleteSubscribedUsers'])->name('DeleteSubscribedUsers');
Route::get('/download/subscribed/users/excel', [SubscribedUsersController::class, 'downloadSubscribedUsersExcel'])->name('DownloadSubscribedUsersExcel');
Route::get('/subscribed/users/send-email', [SubscribedUsersController::class, 'sendEmailPage'])->name('SendEmailSubscribedUsers');
Route::post('/subscribed/users/send-email', [SubscribedUsersController::class, 'sendBulkEmail'])->name('SendBulkEmailSubscribedUsers');
