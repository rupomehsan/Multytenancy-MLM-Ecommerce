<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Actions\SaveNewBlog;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Actions\ViewAllBlogs;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Actions\DeleteBlog;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Actions\GetBlogForEdit;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Actions\UpdateBlog;
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
        $this->loadModuleViewPath('ECOMMERCE/Managements/WebSiteContentManagement/BlogManagements/Blogs');
    }

    // Category methods (shared with BlogCategory controller)
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

    // Blog methods
    public function addNewBlog()
    {
        return view('create');
    }

    public function saveNewBlog(Request $request)
    {
        $result = SaveNewBlog::execute($request);
        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function viewAllBlogs(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllBlogs::execute($request);
        }
        return view('view');
    }

    public function deleteBlog($slug)
    {
        $result = DeleteBlog::execute($slug);
        return response()->json(['success' => $result['message']]);
    }

    public function editBlog($slug)
    {
        $result = GetBlogForEdit::execute($slug);
        
        if ($result['status'] == 'error') {
            Toastr::error($result['message'], 'Error');
            return redirect()->back();
        }

        return view('edit', compact('data', 'categoriesDropdown'))->with($result);
    }

    public function updateBlog(Request $request)
    {
        $result = UpdateBlog::execute($request);
        Toastr::success($result['message'], 'Success');
        $data = $result['data'];
        return view('edit', compact('data'));
    }
}
