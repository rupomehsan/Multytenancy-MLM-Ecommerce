<?php


use Illuminate\Support\Facades\Route;
use App\Modules\Inventory\Managements\Report\Controllers\ReportController;

Route::get('/product/purchase/report', [ReportController::class, 'productPurchaseReport'])->name('productPurchaseReport');
Route::post('/generate/product/purchase/report', [ReportController::class, 'generateProductPurchaseReport'])->name('generateProductPurchaseReport');
