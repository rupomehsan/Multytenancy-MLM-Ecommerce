<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\FAQ\Controllers\FaqController;

// auth routes
Route::get('/view/all/faqs', [FaqController::class, 'viewAllFaqs'])->name('ViewAllFaqs');
Route::get('/add/new/faq', [FaqController::class, 'addNewFaq'])->name('AddNewFaq');
Route::post('/save/faq', [FaqController::class, 'saveFaq'])->name('SaveFaq');
Route::get('/delete/faq/{slug}', [FaqController::class, 'deleteFaq'])->name('DeleteFaq');
Route::get('/edit/faq/{slug}', [FaqController::class, 'editFaq'])->name('EditFaq');
Route::post('/update/faq', [FaqController::class, 'updateFaq'])->name('UpdateFaq');
