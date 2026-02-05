<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Outlets\Controllers\OutletController;

Route::get('/add/new/outlet', [OutletController::class, 'addNewOutlet'])->name('AddNewOutlet');
Route::post('/save/new/outlet', [OutletController::class, 'saveNewOutlet'])->name('SaveNewOutlet');
Route::get('/view/all/outlet', [OutletController::class, 'viewAllOutlet'])->name('ViewAllOutlet');
Route::get('/delete/outlet/{slug}', [OutletController::class, 'deleteOutlet'])->name('DeleteOutlet');
Route::get('/edit/outlet/{slug}', [OutletController::class, 'editOutlet'])->name('EditOutlet');
Route::post('/update/outlet', [OutletController::class, 'updateOutlet'])->name('UpdateOutlet');
