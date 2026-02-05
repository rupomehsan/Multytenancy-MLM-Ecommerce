<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Controllers\SubcategoryController;

//  sub category routes
Route::get('/add/new/subcategory', [SubcategoryController::class, 'addNewSubcategory'])->name('AddNewSubcategory');
Route::post('/save/new/subcategory', [SubcategoryController::class, 'saveNewSubcategory'])->name('SaveNewSubcategory');
Route::get('/view/all/subcategory', [SubcategoryController::class, 'viewAllSubcategory'])->name('ViewAllSubcategory');
Route::get('/delete/subcategory/{slug}', [SubcategoryController::class, 'deleteSubcategory'])->name('DeleteSubcategory');
Route::get('/feature/subcategory/{id}', [SubcategoryController::class, 'featureSubcategory'])->name('FeatureSubcategory');
Route::get('/edit/subcategory/{slug}', [SubcategoryController::class, 'editSubcategory'])->name('EditSubcategory');
Route::post('/update/subcategory', [SubcategoryController::class, 'updateSubcategory'])->name('UpdateSubcategory');
Route::get('/rearrange/subcategory', [SubcategoryController::class, 'rearrangeSubcategory'])->name('RearrangeSubcategory');
Route::post('/save/rearranged/subcategory', [SubcategoryController::class, 'saveRearrangedSubcategory'])->name('SaveRearrangedSubcategory');
