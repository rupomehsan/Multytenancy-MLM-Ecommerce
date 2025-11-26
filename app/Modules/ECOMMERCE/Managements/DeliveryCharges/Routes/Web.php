<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\DeliveryCharges\Controllers\DeliveryChargeController;

Route::get('/view/delivery/charges', [DeliveryChargeController::class, 'viewAllDeliveryCharges'])->name('ViewAllDeliveryCharges');
Route::get('/get/delivery/charge/{id}', [DeliveryChargeController::class, 'getDeliveryCharge'])->name('GetDeliveryCharge');
Route::post('/update/delivery/charge', [DeliveryChargeController::class, 'updateDeliveryCharge'])->name('UpdateDeliveryCharge');

// upazaila thana
Route::get('view/upazila/thana', [DeliveryChargeController::class, 'viewUpazilaThana'])->name('ViewUpazilaThana');
Route::get('get/upazila/info/{id}', [DeliveryChargeController::class, 'getUpazilaInfo'])->name('getUpazilaInfo');
Route::post('update/upazila/info', [DeliveryChargeController::class, 'updateUpazilaInfo'])->name('UpdateUpazilaInfo');
Route::post('save/new/upazila', [DeliveryChargeController::class, 'saveNewUpazila'])->name('SaveNewUpazila');
Route::get('delete/upazila/{id}', [DeliveryChargeController::class, 'deleteUpazila'])->name('DeleteUpazila');
