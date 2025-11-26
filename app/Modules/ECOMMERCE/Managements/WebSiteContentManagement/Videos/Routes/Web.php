<?php


use Illuminate\Support\Facades\Route;
use App\Modules\{path}\Controller;

    Route::get('/add/new/video-gallery', [VideoGalleryController::class, 'addNewVideoGallery'])->name('AddNewVideoGallery');
    Route::post('/save/new/video-gallery', [VideoGalleryController::class, 'saveNewVideoGallery'])->name('SaveNewVideoGallery');
    Route::get('/view/all/video-gallery', [VideoGalleryController::class, 'viewAllVideoGallery'])->name('ViewAllVideoGallery');
    Route::get('/delete/video-gallery/{slug}', [VideoGalleryController::class, 'deleteVideoGallery'])->name('DeleteVideoGallery');
    Route::get('/edit/video-gallery/{slug}', [VideoGalleryController::class, 'editVideoGallery'])->name('EditVideoGallery');
    Route::post('/update/video-gallery', [VideoGalleryController::class, 'updateVideoGallery'])->name('UpdateVideoGallery');

