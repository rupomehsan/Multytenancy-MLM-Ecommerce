<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions\ViewBlogCategories;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions\SaveBlogCategory;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions\DeleteBlogCategory;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions\FeatureBlogCategory;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions\GetBlogCategoryInfo;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions\UpdateBlogCategoryInfo;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions\GetRearrangeBlogCategory;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\BlogCategory\Actions\SaveRearrangeCategory;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebSiteContentManagement/BlogManagements/BlogCategory');
    }

    public function blogCategories(Request $request)
    {
        if ($request->ajax()) {
            return ViewBlogCategories::execute($request);
        }
        return view('category');
    }

    public function saveBlogCategory(Request $request)
    {
        $result = SaveBlogCategory::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function deleteBlogCategory($slug)
    {
        $result = DeleteBlogCategory::execute($slug);
        return response()->json(['success' => $result['message'], 'data' => $result['data']]);
    }

    public function featureBlogCategory($slug)
    {
        $result = FeatureBlogCategory::execute($slug);
        return response()->json(['success' => $result['message']]);
    }

    public function getBlogCategoryInfo($slug)
    {
        $result = GetBlogCategoryInfo::execute($slug);
        return response()->json($result['data']);
    }

    public function updateBlogCategoryInfo(Request $request)
    {
        $result = UpdateBlogCategoryInfo::execute($request);
        return response()->json(['success' => $result['message']]);
    }

    public function rearrangeBlogCategory()
    {
        $result = GetRearrangeBlogCategory::execute();
        return view('rearrange', compact('categories'))->with($result);
    }

    public function saveRearrangeCategory(Request $request)
    {
        $result = SaveRearrangeCategory::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect('/blog/categories');
    }
}
