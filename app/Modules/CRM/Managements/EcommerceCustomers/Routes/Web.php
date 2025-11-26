<?php


use Illuminate\Support\Facades\Route;
use App\Modules\CRM\Managements\EcommerceCustomers\Controllers\CustomerEcommerceController;

/*
|--------------------------------------------------------------------------
| Ecommerce Customer Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for ecommerce customer management in the CRM module. These
|
*/

Route::get('/add/new/customer-ecommerce', [CustomerEcommerceController::class, 'addNewCustomerEcommerce'])->name('AddNewCustomerEcommerce');
Route::post('/save/new/customer-ecommerce', [CustomerEcommerceController::class, 'saveNewCustomerEcommerce'])->name('SaveNewCustomerEcommerce');
Route::get('/view/all/customer-ecommerce', [CustomerEcommerceController::class, 'viewAllCustomerEcommerce'])->name('ViewAllCustomerEcommerce');
Route::get('/delete/customer-ecommerce/{slug}', [CustomerEcommerceController::class, 'deleteCustomerEcommerce'])->name('DeleteCustomerEcommerce');
Route::get('/edit/customer-ecommerce/{slug}', [CustomerEcommerceController::class, 'editCustomerEcommerce'])->name('EditCustomerEcommerce');
Route::post('/update/customer-ecommerce', [CustomerEcommerceController::class, 'updateCustomerEcommerce'])->name('UpdateCustomerEcommerce');
