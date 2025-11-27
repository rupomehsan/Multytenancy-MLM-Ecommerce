<?php


use Illuminate\Support\Facades\Route;
use App\Modules\INVENTORY\Managements\SupplierType\Controllers\SupplierSourceController;

Route::get('/add/new/supplier-source', [SupplierSourceController::class, 'addNewSupplierSource'])->name('AddNewSupplierSource');
Route::post('/save/new/supplier-source', [SupplierSourceController::class, 'saveNewSupplierSource'])->name('SaveNewSupplierSource');
Route::get('/view/all/supplier-source', [SupplierSourceController::class, 'viewAllSupplierSource'])->name('ViewAllSupplierSource');
Route::get('/delete/supplier-source/{slug}', [SupplierSourceController::class, 'deleteSupplierSource'])->name('DeleteSupplierSource');
Route::get('/edit/supplier-source/{slug}', [SupplierSourceController::class, 'editSupplierSource'])->name('EditSupplierSource');
Route::post('/update/supplier-source', [SupplierSourceController::class, 'updateSupplierSource'])->name('UpdateSupplierSource');
