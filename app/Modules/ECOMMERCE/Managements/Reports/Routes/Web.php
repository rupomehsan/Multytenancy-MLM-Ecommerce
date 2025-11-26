<?php

use App\Modules\ECOMMERCE\Managements\Reports\Controllers\ReportController;

use Illuminate\Support\Facades\Route;




Route::get('sales/report', [ReportController::class, 'salesReport'])->name('SalesReport');
Route::post('generate/sales/report', [ReportController::class, 'generateSalesReport'])->name('GenerateSalesReport');
