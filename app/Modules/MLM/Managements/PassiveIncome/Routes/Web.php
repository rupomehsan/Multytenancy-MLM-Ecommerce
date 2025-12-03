<?php


use Illuminate\Support\Facades\Route;
use App\Modules\MLM\Managements\PassiveIncome\Controllers\PassiveIncomeController as Controller;

// auth routes

Route::get('/mlm/passive-income', [Controller::class, 'index'])->name('mlm.passive.income');
