<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Controllers\BlogController;

// auth routes
Route::get('/add/new/blog', [BlogController::class, 'addNewBlog'])->name('AddNewBlog');
Route::post('/save/new/blog', [BlogController::class, 'saveNewBlog'])->name('SaveNewBlog');
Route::get('/view/all/blogs', [BlogController::class, 'viewAllBlogs'])->name('ViewAllBlogs');
Route::get('/delete/blog/{slug}', [BlogController::class, 'deleteBlog'])->name('DeleteBlog');
Route::get('/edit/blog/{slug}', [BlogController::class, 'editBlog'])->name('EditBlog');
Route::post('/update/blog', [BlogController::class, 'updateBlog'])->name('UpdateBlog');
