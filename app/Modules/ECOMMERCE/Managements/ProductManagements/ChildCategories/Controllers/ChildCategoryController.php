<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Actions\GetChildCategoryFormData;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Actions\GetSubcategoriesByCategoryId;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Actions\CreateChildCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Actions\ViewAllChildCategories;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Actions\GetChildCategoryForEdit;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Actions\UpdateChildCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Actions\DeleteChildCategory;

class ChildCategoryController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/ChildCategories');
    }

    public function addNewChildcategory()
    {
        $result = GetChildCategoryFormData::execute(request());
        return view($result['view'], ['category' => $result['category']]);
    }

    public function subcategoryCategoryWise(Request $request)
    {
        $result = GetSubcategoriesByCategoryId::execute($request);
        return response()->json($result['data']);
    }

    public function saveNewChildcategory(Request $request)
    {
        $result = CreateChildCategory::execute($request);

        if ($result['status'] === 'error') {
            if (isset($result['errors'])) {
                return back()->withErrors($result['errors'])->withInput();
            }
            Toastr::error($result['message'], 'Error');
            return back();
        }

        Toastr::success($result['message'], 'Success');
        return back();
    }

    public function viewAllChildcategory(Request $request)
    {
        $result = ViewAllChildCategories::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view($result['view']);
    }

    public function deleteChildcategory($slug)
    {
        $result = DeleteChildCategory::execute(request(), $slug);
        return response()->json(['success' => $result['message'], 'data' => $result['data']]);
    }

    public function editChildcategory($slug)
    {
        $result = GetChildCategoryForEdit::execute(request(), $slug);

        if ($result['status'] === 'error') {
            Toastr::error($result['message'], 'Error');
            return redirect()->route('ViewAllChildcategory');
        }

        return view($result['view'], [
            'childcategory' => $result['childcategory'],
            'subcategories' => $result['subcategories'],
            'category' => $result['category']
        ]);
    }

    public function updateChildcategory(Request $request)
    {
        $result = UpdateChildCategory::execute($request);

        if ($result['status'] === 'error') {
            if (isset($result['errors'])) {
                return back()->withErrors($result['errors'])->withInput();
            }
            Toastr::warning($result['message'], 'Error');
            return back();
        }

        Toastr::success($result['message'], 'Success');
        return redirect()->route('ViewAllChildcategory');
    }
}
