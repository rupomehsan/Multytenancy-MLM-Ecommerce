<?php


use Illuminate\Support\Facades\Route;
use App\Modules\CRM\Managements\NextDateContacts\Controllers\CustomerNextContactDateController;
/*
|--------------------------------------------------------------------------
| Next Date Contact Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for next date contact management in the CRM module. These
|
*/

Route::get('/add/new/customer-next-contact-date', [CustomerNextContactDateController::class, 'addNewCustomerNextContactDate'])->name('AddNewCustomerNextContactDate');
Route::post('/save/new/customer-next-contact-date', [CustomerNextContactDateController::class, 'saveNewCustomerNextContactDate'])->name('SaveNewCustomerNextContactDate');
Route::get('/view/all/customer-next-contact-date', [CustomerNextContactDateController::class, 'viewAllCustomerNextContactDate'])->name('ViewAllCustomerNextContactDate');
Route::get('/delete/customer-next-contact-date/{slug}', [CustomerNextContactDateController::class, 'deleteCustomerNextContactDate'])->name('DeleteCustomerNextContactDate');
Route::get('/edit/customer-next-contact-date/{slug}', [CustomerNextContactDateController::class, 'editCustomerNextContactDate'])->name('EditCustomerNextContactDate');
Route::post('/update/customer-next-contact-date', [CustomerNextContactDateController::class, 'updateCustomerNextContactDate'])->name('UpdateCustomerNextContactDate');
