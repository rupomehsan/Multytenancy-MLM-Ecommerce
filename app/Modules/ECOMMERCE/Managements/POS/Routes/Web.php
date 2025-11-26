<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\POS\Controllers\InvoiceController;


Route::get('/pos/invoice/print/{id}', [InvoiceController::class, 'posInvoicePrint'])->name('POSInvoicePrint');
Route::get('/pos/invoice/content/{id}', [InvoiceController::class, 'getPrintableContent'])->name('POSInvoiceContent');
Route::get('/view/all/invoices', [InvoiceController::class, 'index'])->name('ViewAllInvoices');
Route::get('/invoice/show/{id}', [InvoiceController::class, 'showInvoice'])->name('ShowInvoice');
Route::get('/invoice/print/{id}', [InvoiceController::class, 'printInvoice'])->name('PrintInvoice');
Route::post('/invoice/generate/{id}', [InvoiceController::class, 'generateInvoice'])->name('GenerateInvoice');
