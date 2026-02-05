<?php


use Illuminate\Support\Facades\Route;
use App\Modules\CRM\Managements\ContactHistory\Controllers\CustomerContactHistoryController;
/*
|--------------------------------------------------------------------------
| Contact History Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for contact history management in the CRM module. These
|
*/

Route::get('/add/new/customer-contact-history', [CustomerContactHistoryController::class, 'addNewCustomerContactHistory'])->name('AddNewCustomerContactHistories');
Route::post('/save/new/customer-contact-history', [CustomerContactHistoryController::class, 'saveNewCustomerContactHistory'])->name('SaveNewCustomerContactHistories');
Route::get('/view/all/customer-contact-history', [CustomerContactHistoryController::class, 'viewAllCustomerContactHistory'])->name('ViewAllCustomerContactHistories');
Route::get('/delete/customer-contact-history/{slug}', [CustomerContactHistoryController::class, 'deleteCustomerContactHistory'])->name('DeleteCustomerContactHistories');
Route::get('/edit/customer-contact-history/{slug}', [CustomerContactHistoryController::class, 'editCustomerContactHistory'])->name('EditCustomerContactHistories');
Route::post('/update/customer-contact-history', [CustomerContactHistoryController::class, 'updateCustomerContactHistory'])->name('UpdateCustomerContactHistories');
