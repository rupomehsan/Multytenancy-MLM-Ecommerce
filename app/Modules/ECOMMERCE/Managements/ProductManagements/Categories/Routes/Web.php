<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Controllers\CategoryController;


Route::get('/add/new/category', [CategoryController::class, 'addNewCategory'])->name('AddNewCategory');
Route::post('/save/new/category', [CategoryController::class, 'saveNewCategory'])->name('SaveNewCategory');
Route::get('/view/all/category', [CategoryController::class, 'viewAllCategory'])->name('ViewAllCategory');
Route::get('/delete/category/{slug}', [CategoryController::class, 'deleteCategory'])->name('DeleteCategory');
Route::get('/feature/category/{slug}', [CategoryController::class, 'featureCategory'])->name('FeatureCategory');
Route::get('/edit/category/{slug}', [CategoryController::class, 'editCategory'])->name('EditCategory');
Route::post('/update/category', [CategoryController::class, 'updateCategory'])->name('UpdateCategory');
Route::get('/rearrange/category', [CategoryController::class, 'rearrangeCategory'])->name('RearrangeCategory');
Route::post('/save/rearranged/order', [CategoryController::class, 'saveRearrangeCategoryOrder'])->name('SaveRearrangeCategoryOrder');
