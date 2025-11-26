<?php


use Illuminate\Support\Facades\Route;
use App\Modules\CRM\Managements\CustomerCategory\Controllers\CustomerCategoryController;
/*
|--------------------------------------------------------------------------
| Customer Category Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for customer category management in the CRM module. These
|
*/

Route::get('/add/new/customer-category', [CustomerCategoryController::class, 'addNewCustomerCategory'])->name('AddNewCustomerCategory');
Route::post('/save/new/customer-category', [CustomerCategoryController::class, 'saveNewCustomerCategory'])->name('SaveNewCustomerCategory');
Route::get('/view/all/customer-category', [CustomerCategoryController::class, 'viewAllCustomerCategory'])->name('ViewAllCustomerCategory');
Route::get('/delete/customer-category/{slug}', [CustomerCategoryController::class, 'deleteCustomerCategory'])->name('DeleteCustomerCategory');
Route::get('/edit/customer-category/{slug}', [CustomerCategoryController::class, 'editCustomerCategory'])->name('EditCustomerCategory');
Route::post('/update/customer-category', [CustomerCategoryController::class, 'updateCustomerCategory'])->name('UpdateCustomerCategory');
