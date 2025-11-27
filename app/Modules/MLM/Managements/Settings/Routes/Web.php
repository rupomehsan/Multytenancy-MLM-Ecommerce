<?php


use Illuminate\Support\Facades\Route;
use App\Modules\MLM\Managements\Settings\Controllers\Controller;

// auth routes
Route::get('/mlm/configuration', [Controller::class, 'index'])->name('mlm.index');
Route::post('/mlm/update-configuration', [Controller::class, 'update'])->name('mlm.update');
