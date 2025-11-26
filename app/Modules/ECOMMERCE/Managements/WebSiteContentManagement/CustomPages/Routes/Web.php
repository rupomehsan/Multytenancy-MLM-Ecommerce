<?php


use Illuminate\Support\Facades\Route;
use App\Modules\{path}\Controller;

    Route::get('create/new/page', [CustomPageController::class, 'createNewPage'])->name('CreateNewPage');
    Route::post('save/custom/page', [CustomPageController::class, 'saveCustomPage'])->name('SaveCustomPage');
    Route::get('view/all/pages', [CustomPageController::class, 'viewCustomPages'])->name('ViewCustomPages');
    Route::get('delete/custom/page/{slug}', [CustomPageController::class, 'deleteCustomPage'])->name('DeleteCustomPage');
    Route::get('edit/custom/page/{slug}', [CustomPageController::class, 'editCustomPage'])->name('EditCustomPage');
    Route::post('update/custom/page', [CustomPageController::class, 'updateCustomPage'])->name('UpdateCustomPage');

    //about
    Route::get('/about/us/page', [GeneralInfoController::class, 'aboutUsPage'])->name('AboutUsPage');
    Route::post('/update/about/us', [GeneralInfoController::class, 'updateAboutUsPage'])->name('UpdateAboutUsPage');
