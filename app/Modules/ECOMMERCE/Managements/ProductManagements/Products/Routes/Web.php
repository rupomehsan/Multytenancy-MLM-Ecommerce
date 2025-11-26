<?php


use Illuminate\Support\Facades\Route;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Controllers\ProductController;

use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Controllers\PackageProductController;
// auth routes
Route::get('/add/new/product', [ProductController::class, 'addNewProduct'])->name('AddNewProduct');
Route::post('/subcategory/wise/childcategory', [ProductController::class, 'childcategorySubcategoryWise'])->name('ChildcategorySubcategoryWise');
Route::post('/save/new/product', [ProductController::class, 'saveNewProduct'])->name('SaveNewProduct');
Route::get('/view/all/product', [ProductController::class, 'viewAllProducts'])->name('ViewAllProducts');
Route::get('/delete/product/{slug}', [ProductController::class, 'deleteProduct'])->name('DeleteProduct');
Route::get('/edit/product/{slug}', [ProductController::class, 'editProduct'])->name('EditProduct');
Route::post('/update/product', [ProductController::class, 'updateProduct'])->name('UpdateProduct');
Route::post('/add/another/variant', [ProductController::class, 'addAnotherVariant'])->name('AddAnotherVariant');
Route::get('/delete/product/variant/{id}', [ProductController::class, 'deleteProductVariant'])->name('DeleteProductVariant');
Route::get('/products/from/excel', [ProductController::class, 'productsFromExcel'])->name('ProductsFromExcel');
Route::post('/upload/product/from/excel', [ProductController::class, 'uploadProductsFromExcel'])->name('UploadProductsFromExcel');
// product review routes
Route::get('/view/product/reviews', [ProductController::class, 'viewAllProductReviews'])->name('ViewAllProductReviews');
Route::get('/approve/product/review/{slug}', [ProductController::class, 'approveProductReview'])->name('ApproveProductReview');
Route::get('/delete/product/review/{slug}', [ProductController::class, 'deleteProductReview'])->name('DeleteProductReview');
Route::get('/get/product/review/info/{id}', [ProductController::class, 'getProductReviewInfo'])->name('GetProductReviewInfo');
Route::post('/submit/reply/product/review', [ProductController::class, 'submitReplyOfProductReview'])->name('SubmitReplyOfProductReview');


// product question answer
Route::get('/view/product/question/answer', [ProductController::class, 'viewAllQuestionAnswer'])->name('ViewAllQuestionAnswer');
Route::get('/delete/question/answer/{id}', [ProductController::class, 'deleteQuestionAnswer'])->name('DeleteQuestionAnswer');
Route::get('/get/question/answer/info/{id}', [ProductController::class, 'getQuestionAnswerInfo'])->name('GetQuestionAnswerInfo');
Route::post('/submit/question/answer', [ProductController::class, 'submitAnswerOfQuestion'])->name('SubmitAnswerOfQuestion');


// Package Product routes
Route::get('package-products', [PackageProductController::class, 'index'])->name('PackageProducts.Index');
Route::get('package-products/data', [PackageProductController::class, 'getData'])->name('PackageProducts.Data');
Route::get('package-products/create', [PackageProductController::class, 'create'])->name('PackageProducts.Create');
Route::post('package-products', [PackageProductController::class, 'store'])->name('PackageProducts.Store');
Route::get('package-products/{id}/edit', [PackageProductController::class, 'edit'])->name('PackageProducts.Edit');
Route::put('package-products/{id}', [PackageProductController::class, 'update'])->name('PackageProducts.Update');
Route::delete('package-products/{id}', [PackageProductController::class, 'destroy'])->name('PackageProducts.Destroy');
Route::get('package-products/{id}/manage-items', [PackageProductController::class, 'manageItems'])->name('PackageProducts.ManageItems');
Route::post('package-products/{id}/add-item', [PackageProductController::class, 'addItem'])->name('PackageProducts.AddItem');
Route::put('package-products/{packageId}/items/{itemId}', [PackageProductController::class, 'updateItem'])->name('PackageProducts.UpdateItem');
Route::delete('package-products/{packageId}/items/{itemId}', [PackageProductController::class, 'removeItem'])->name('PackageProducts.RemoveItem');
Route::get('get-product-variants/{productId}', [PackageProductController::class, 'getProductVariants'])->name('GetProductVariants');
Route::post('get-variant-stock/{productId}', [PackageProductController::class, 'getVariantStock'])->name('GetVariantStock');
// demo products route
Route::get('generate/demo/products', [ProductController::class, 'generateDemoProducts'])->name('GenerateDemoProducts');
Route::post('save/generated/demo/products', [ProductController::class, 'saveGeneratedDemoProducts'])->name('SaveGeneratedDemoProducts');
Route::get('remove/demo/products/page', [ProductController::class, 'removeDemoProductsPage'])->name('RemoveDemoProductsPage');
Route::get('remove/demo/products', [ProductController::class, 'removeDemoProducts'])->name('RemoveDemoProducts');
