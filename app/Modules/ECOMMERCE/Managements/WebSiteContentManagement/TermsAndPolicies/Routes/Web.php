<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\TermsAndPolicies\Controllers\TermsAndPolicyController;


Route::get('/terms/and/condition', [TermsAndPolicyController::class, 'viewTermsAndCondition'])->name('ViewTermsAndCondition');
Route::post('/update/terms', [TermsAndPolicyController::class, 'updateTermsAndCondition'])->name('UpdateTermsAndCondition');
Route::get('/view/privacy/policy', [TermsAndPolicyController::class, 'viewPrivacyPolicy'])->name('ViewPrivacyPolicy');
Route::post('/update/privacy/policy', [TermsAndPolicyController::class, 'updatePrivacyPolicy'])->name('UpdatePrivacyPolicy');
Route::get('/view/shipping/policy', [TermsAndPolicyController::class, 'viewShippingPolicy'])->name('ViewShippingPolicy');
Route::post('/update/shipping/policy', [TermsAndPolicyController::class, 'updateShippingPolicy'])->name('UpdateShippingPolicy');
Route::get('/view/return/policy', [TermsAndPolicyController::class, 'viewReturnPolicy'])->name('ViewReturnPolicy');
Route::post('/update/return/policy', [TermsAndPolicyController::class, 'updateReturnPolicy'])->name('UpdateReturnPolicy');
