<?php


use Illuminate\Support\Facades\Route;
use App\Modules\CRM\Managements\CustomerSourceType\Controllers\CustomerSourceController;
/*
|--------------------------------------------------------------------------
| Customer Source Type Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for customer source type management in the CRM module. These
|
*/

Route::get('/add/new/customer-source', [CustomerSourceController::class, 'addNewCustomerSource'])->name('AddNewCustomerSource');
Route::post('/save/new/customer-source', [CustomerSourceController::class, 'saveNewCustomerSource'])->name('SaveNewCustomerSource');
Route::get('/view/all/customer-source', [CustomerSourceController::class, 'viewAllCustomerSource'])->name('ViewAllCustomerSource');
Route::get('/delete/customer-source/{slug}', [CustomerSourceController::class, 'deleteCustomerSource'])->name('DeleteCustomerSource');
Route::get('/edit/customer-source/{slug}', [CustomerSourceController::class, 'editCustomerSource'])->name('EditCustomerSource');
Route::post('/update/customer-source', [CustomerSourceController::class, 'updateCustomerSource'])->name('UpdateCustomerSource');
