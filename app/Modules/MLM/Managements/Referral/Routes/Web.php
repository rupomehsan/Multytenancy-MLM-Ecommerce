<?php


use Illuminate\Support\Facades\Route;
use App\Modules\MLM\Managements\Referral\Controllers\ReferralController;

// auth routes
Route::get('/mlm/referral-lists', [ReferralController::class, 'referral_list'])->name('mlm.referral.lists');
Route::get('/mlm/referral-tree', [ReferralController::class, 'referral_tree'])->name('mlm.referral.tree');
Route::get('/mlm/referral-activity-log', [ReferralController::class, 'referral_activity_log'])->name('mlm.referral.activity.log');
