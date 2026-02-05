<?php


use Illuminate\Support\Facades\Route;
use App\Modules\CRM\Managements\Customers\Controllers\CustomerController;
/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for customer management in the CRM module. These
|
*/

Route::get('/add/new/customers', [CustomerController::class, 'addNewCustomer'])->name('AddNewCustomers');
Route::post('/save/new/customers', [CustomerController::class, 'saveNewCustomer'])->name('SaveNewCustomers');
Route::get('/view/all/customer', [CustomerController::class, 'viewAllCustomer'])->name('ViewAllCustomer');
Route::get('/delete/customers/{slug}', [CustomerController::class, 'deleteCustomer'])->name('DeleteCustomers');
Route::get('/edit/customers/{slug}', [CustomerController::class, 'editCustomer'])->name('EditCustomers');
Route::post('/update/customers', [CustomerController::class, 'updateCustomer'])->name('UpdateCustomers');
