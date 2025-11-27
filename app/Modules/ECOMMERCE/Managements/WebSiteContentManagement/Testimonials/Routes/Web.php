<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Controllers\TestimonialController;

Route::get('/view/testimonials', [TestimonialController::class, 'viewTestimonials'])->name('ViewTestimonials');
Route::get('/add/testimonial', [TestimonialController::class, 'addTestimonial'])->name('AddTestimonial');
Route::post('/save/testimonial', [TestimonialController::class, 'saveTestimonial'])->name('SaveTestimonial');
Route::get('/delete/testimonial/{slug}', [TestimonialController::class, 'deleteTestimonial'])->name('DeleteTestimonial');
Route::get('/edit/testimonial/{slug}', [TestimonialController::class, 'editTestimonial'])->name('EditTestimonial');
Route::post('/update/testimonial', [TestimonialController::class, 'updateTestimonial'])->name('UpdateTestimonial');
