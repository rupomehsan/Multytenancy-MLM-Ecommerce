<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Actions\ViewAllModels;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Actions\GetModelFormData;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Actions\CreateModel;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Actions\GetModelForEdit;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Actions\UpdateModel;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Actions\DeleteModel;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Actions\GetModelsByBrandId;

use App\Http\Controllers\Controller;

class ProductModelController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/ProductAttributes/Models');
    }
    public function viewAllModels(Request $request)
    {
        $result = ViewAllModels::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view('view');
    }

    public function addNewModel()
    {
        $result = GetModelFormData::execute(request());
        return view('create', compact('brands'))->with('brands', $result['data']['brands']);
    }

    public function saveNewModel(Request $request)
    {
        $result = CreateModel::execute($request);

        if ($result['status'] === 'success') {
            Toastr::success($result['message'], 'Success');
        } else {
            Toastr::error($result['message'], 'Error');
        }

        return back();
    }

    public function deleteModel($id)
    {
        $result = DeleteModel::execute(request(), $id);
        return response()->json(['success' => $result['message']]);
    }

    public function editModel($slug)
    {
        $result = GetModelForEdit::execute(request(), $slug);
        return view('update', $result['data']);
    }

    public function updateModel(Request $request)
    {
        $result = UpdateModel::execute($request);

        if ($result['status'] === 'success') {
            Toastr::success($result['message'], 'Success');
            return redirect('/view/all/models');
        } else {
            Toastr::error($result['message'], 'Error');
            return back();
        }
    }

    public function brandWiseModel(Request $request)
    {
        $result = GetModelsByBrandId::execute($request);
        return response()->json($result['data']);
    }
}
