<?php


use Illuminate\Support\Facades\Route;
use App\Modules\MLM\Managements\TopEarners\Controllers\TopEarnerController as Controller;


// auth routes


Route::get('/mlm/top-earners', [Controller::class, 'index'])->name('mlm.top.earners');
