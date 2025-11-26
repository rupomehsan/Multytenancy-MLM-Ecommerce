<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CustomPageController;
use App\Http\Controllers\SideBannerController;
use App\Http\Controllers\GeneralInfoController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\Outlet\OutletController;
use App\Http\Controllers\TermsAndPolicyController;
use App\Http\Controllers\Gallery\VideoGalleryController;


Route::group(['middleware' => ['auth', 'CheckUserType', 'DemoMode']], function () {

    // sliders and banners routes
    require __DIR__ . '/../app/Modules/ECOMMERCE/Managements/WebSiteContentManagement/Banners/Routes/Web.php';
    // SideBanner Management
    require __DIR__ . '/../app/Modules/ECOMMERCE/Managements/WebSiteContentManagement/SideBanner/Routes/Web.php';
    // testimonial routes
    require __DIR__ . '/../app/Modules/ECOMMERCE/Managements/WebSiteContentManagement/Testimonials/Routes/Web.php';
    // blog category routes
    require __DIR__ . '/../app/Modules/ECOMMERCE/Managements/WebSiteContentManagement/BlogManagements/BlogCategory/Routes/Web.php';
    // blog routes
    require __DIR__ . '/../app/Modules/ECOMMERCE/Managements/WebSiteContentManagement/BlogManagements/Blogs/Routes/Web.php';
    // terms and policies routes
    require __DIR__ . '/../app/Modules/ECOMMERCE/Managements/WebSiteContentManagement/TermsAndPolicies/Routes/Web.php';
    // custom page
    require __DIR__ . '/../app/Modules/ECOMMERCE/Managements/WebSiteContentManagement/CustomPages/Routes/Web.php';
    // Outlets
    require __DIR__ . '/../app/Modules/ECOMMERCE/Managements/WebSiteContentManagement/Outlets/Routes/Web.php';
    // Video Gallery
    require __DIR__ . '/../app/Modules/ECOMMERCE/Managements/WebSiteContentManagement/Videos/Routes/Web.php';

    // faq routes
    require __DIR__ . '/../app/Modules/ECOMMERCE/Managements/WebSiteContentManagement/FAQ/Routes/Web.php';
});
