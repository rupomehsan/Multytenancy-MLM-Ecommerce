<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Controllers\UserController;

Route::get('/view/all/customers', [UserController::class, 'viewAllCustomers'])->name('ViewAllCustomers');
Route::get('/view/system/users', [UserController::class, 'viewAllSystemUsers'])->name('ViewAllSystemUsers');
Route::get('/add/new/system/user', [UserController::class, 'addNewSystemUsers'])->name('AddNewSystemUsers');
Route::post('/create/system/user', [UserController::class, 'createSystemUsers'])->name('CreateSystemUsers');
Route::get('/edit/system/user/{id}', [UserController::class, 'editSystemUser'])->name('EditSystemUser');
Route::get('/delete/system/user/{id}', [UserController::class, 'deleteSystemUser'])->name('DeleteSystemUser');
Route::post('/update/system/user', [UserController::class, 'updateSystemUser'])->name('UpdateSystemUser');
Route::get('make/user/superadmin/{id}', [UserController::class, 'makeSuperAdmin'])->name('MakeSuperAdmin');
Route::get('revoke/user/superadmin/{id}', [UserController::class, 'revokeSuperAdmin'])->name('RevokeSuperAdmin');
Route::get('/change/user/status/{id}', [UserController::class, 'changeUserStatus'])->name('ChangeUserStatus');
Route::get('/delete/customer/{id}', [UserController::class, 'deleteCustomer'])->name('DeleteCustomer');
Route::get('download/customer/excel', [UserController::class, 'downloadCustomerExcel'])->name('DownloadCustomerExcel');
