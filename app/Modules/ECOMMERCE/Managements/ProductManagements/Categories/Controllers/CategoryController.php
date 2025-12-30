<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions\SaveNewCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions\ViewAllCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions\DeleteCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions\FeatureCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions\GetCategoryForEdit;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions\UpdateCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions\ViewRearrangeCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions\SaveRearrangeCategoryOrder;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/Categories');
    }

    public function addNewCategory()
    {
        return view('create');
    }

    public function saveNewCategory(Request $request)
    {
        $data = SaveNewCategory::execute($request);

        if (isset($data['error'])) {
            Toastr::error($data['error'], 'Failed');
            return back();
        }

        Toastr::success('New Category has been Created', 'Success');
        return redirect('/view/all/category');
    }

    public function viewAllCategory(Request $request)
    {
        if ($request->ajax()) {
            return ViewAllCategory::execute($request);
        }

        return view('view');
    }

    public function deleteCategory($slug)
    {
        $result = DeleteCategory::execute(request(), $slug);
        return response()->json($result);
    }

    public function featureCategory($slug)
    {
        $result = FeatureCategory::execute(request(), $slug);
        return response()->json($result);
    }

    public function editCategory($slug)
    {
        $result = GetCategoryForEdit::execute(request(), $slug);

        if ($result['status'] === 'error') {
            Toastr::error($result['message'], 'Error');
            return redirect('/view/all/category');
        }

        return view($result['view'], [
            'category' => $result['category']
        ]);
    }

    public function updateCategory(Request $request)
    {
        $result = UpdateCategory::execute($request);

        if ($result['status'] === 'error') {
            if (isset($result['errors'])) {
                return redirect()->back()->withErrors($result['errors'])->withInput();
            }
            Toastr::warning($result['message'], 'Error');
            return back();
        }

        Toastr::success($result['message'], 'Success');
        return redirect('/view/all/category');
    }

    public function rearrangeCategory()
    {
        $result = ViewRearrangeCategory::execute(request());

        return view($result['view'], [
            'categories' => $result['categories'] ?? collect()
        ]);
    }

    public function saveRearrangeCategoryOrder(Request $request)
    {
        $result = SaveRearrangeCategoryOrder::execute($request);

        Toastr::success($result['message'] ?? 'Category has been Rerranged', 'Success');
        return redirect('/view/all/category');
    }
}
