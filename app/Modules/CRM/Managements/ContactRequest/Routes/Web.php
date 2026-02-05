<?php


use Illuminate\Support\Facades\Route;
use App\Modules\CRM\Managements\ContactRequest\Controllers\ContactRequestontroller;

/*
|--------------------------------------------------------------------------
| Contact Request Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for contact request management in the CRM module. These
|
*/

Route::get('/view/all/contact/requests', [ContactRequestontroller::class, 'viewAllContactRequests'])->name('ViewAllContactRequests');
Route::get('/delete/contact/request/{id}', [ContactRequestontroller::class, 'deleteContactRequests'])->name('DeleteContactRequests');
Route::get('/change/request/status/{id}', [ContactRequestontroller::class, 'changeRequestStatus'])->name('ChangeRequestStatus');
