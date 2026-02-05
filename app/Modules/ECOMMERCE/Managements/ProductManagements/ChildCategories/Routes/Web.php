<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Controllers\ChildCategoryController;


Route::get('/add/new/childcategory', [ChildCategoryController::class, 'addNewChildcategory'])->name('AddNewChildcategory');
Route::post('/category/wise/subcategory', [ChildCategoryController::class, 'subcategoryCategoryWise'])->name('SubcategoryCategoryWise');
Route::post('/save/new/childcategory', [ChildCategoryController::class, 'saveNewChildcategory'])->name('SaveNewChildcategory');
Route::get('/view/all/childcategory', [ChildCategoryController::class, 'viewAllChildcategory'])->name('ViewAllChildcategory');
Route::get('/delete/childcategory/{slug}', [ChildCategoryController::class, 'deleteChildcategory'])->name('DeleteChildcategory');
Route::get('/edit/childcategory/{slug}', [ChildCategoryController::class, 'editChildcategory'])->name('EditChildcategory');
Route::post('/update/childcategory', [ChildCategoryController::class, 'updateChildcategory'])->name('UpdateChildcategory');
