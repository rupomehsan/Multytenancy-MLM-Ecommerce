<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Controllers\ProductModelController;

// auth routes


Route::get('/add/new/model', [ProductModelController::class, 'addNewModel'])->name('AddNewModel');
Route::post('/save/new/model', [ProductModelController::class, 'saveNewModel'])->name('SaveNewModel');
Route::get('/view/all/models', [ProductModelController::class, 'viewAllModels'])->name('ViewAllModels');
Route::get('/delete/model/{id}', [ProductModelController::class, 'deleteModel'])->name('DeleteModel');
Route::get('/edit/model/{slug}', [ProductModelController::class, 'editModel'])->name('EditModel');
Route::post('/update/model', [ProductModelController::class, 'updateModel'])->name('UpdateModel');
Route::post('/brand/wise/model', [ProductModelController::class, 'brandWiseModel'])->name('BrandWiseModel');
