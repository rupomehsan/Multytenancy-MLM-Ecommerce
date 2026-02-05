<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Controllers\BlogController;

Route::get('/blog/categories', [BlogController::class, 'blogCategories'])->name('BlogCategories');
Route::post('/save/blog/category', [BlogController::class, 'saveBlogCategory'])->name('SaveBlogCategory');
Route::get('/delete/blog/category/{slug}', [BlogController::class, 'deleteBlogCategory'])->name('DeleteBlogCategory');
Route::get('/feature/blog/category/{slug}', [BlogController::class, 'featureBlogCategory'])->name('FeatureBlogCategory');
Route::get('/get/blog/category/info/{slug}', [BlogController::class, 'getBlogCategoryInfo'])->name('GetBlogCategoryInfo');
Route::post('/update/blog/category', [BlogController::class, 'updateBlogCategoryInfo'])->name('UpdateBlogCategoryInfo');
Route::get('/rearrange/blog/category', [BlogController::class, 'rearrangeBlogCategory'])->name('RearrangeBlogCategory');
Route::post('/save/rearranged/blog/categories', [BlogController::class, 'saveRearrangeCategory'])->name('SaveRearrangeCategory');
