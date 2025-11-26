<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Controllers\BrandController;


Route::get('/add/new/brand', [BrandController::class, 'addNewBrand'])->name('AddNewBrand');
Route::post('/save/new/brand', [BrandController::class, 'saveNewBrand'])->name('SaveNewBrand');
Route::get('/view/all/brands', [BrandController::class, 'viewAllBrands'])->name('ViewAllBrands');
Route::get('/rearrange/brands', [BrandController::class, 'rearrangeBrands'])->name('RearrangeBrands');
Route::post('/save/rearranged/brands', [BrandController::class, 'saveRearrangeBrands'])->name('saveRearrangeBrands');
Route::get('/feature/brand/{id}', [BrandController::class, 'featureBrand'])->name('FeatureBrand');
Route::get('/edit/brand/{slug}', [BrandController::class, 'editBrand'])->name('EditBrand');
Route::post('/update/brand', [BrandController::class, 'updateBrand'])->name('UpdateBrand');
Route::get('/delete/brand/{slug}', [BrandController::class, 'deleteBrand'])->name('DeleteBrand');
