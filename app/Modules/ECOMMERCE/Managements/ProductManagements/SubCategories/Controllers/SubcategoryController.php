<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions\GetSubcategoryFormData;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions\ViewAllSubcategories;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions\CreateSubcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions\GetSubcategoryForEdit;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions\UpdateSubcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions\ToggleSubcategoryFeature;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions\DeleteSubcategory;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/SubCategories');
    }

    public function addNewSubcategory()
    {
        $result = GetSubcategoryFormData::execute(request());
        return view($result['view'], ['category' => $result['category']]);
    }

    public function saveNewSubcategory(Request $request)
    {
        $result = CreateSubcategory::execute($request);

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

    public function viewAllSubcategory(Request $request)
    {
        $result = ViewAllSubcategories::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view($result['view']);
    }

    public function deleteSubcategory($slug)
    {
        $result = DeleteSubcategory::execute(request(), $slug);
        return response()->json(['success' => $result['message']]);
    }

    public function editSubcategory($slug)
    {
        $result = GetSubcategoryForEdit::execute(request(), $slug);

        if ($result['status'] === 'error') {
            Toastr::error($result['message'], 'Error');
            return redirect('/view/all/subcategory');
        }

        return view($result['view'], [
            'subcategory' => $result['subcategory'],
            'category' => $result['category']
        ]);
    }

    public function updateSubcategory(Request $request)
    {
        $result = UpdateSubcategory::execute($request);

        if ($result['status'] === 'error') {
            if (isset($result['errors'])) {
                return back()->withErrors($result['errors'])->withInput();
            }
            Toastr::warning($result['message'], 'Error');
            return back();
        }

        Toastr::success($result['message'], 'Success');
        return redirect('/view/all/subcategory');
    }

    public function featureSubcategory($id)
    {
        $result = ToggleSubcategoryFeature::execute(request(), $id);
        return response()->json(['success' => $result['message']]);
    }
}
