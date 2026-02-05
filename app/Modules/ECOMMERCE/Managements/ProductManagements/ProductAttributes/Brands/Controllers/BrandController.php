<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions\GetBrandFormData;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions\ViewAllBrands;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions\CreateBrand;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions\ToggleBrandFeature;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions\GetBrandForEdit;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions\UpdateBrand;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions\ViewRearrangeBrands;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions\SaveRearrangeBrands;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions\DeleteBrand;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/ProductAttributes/Brands');
    }

    public function addNewBrand(Request $request)
    {
        $result = GetBrandFormData::execute($request);

        return view($result['view'], [
            'category' => $result['category'] ?? [],
            'subcategory' => $result['subcategory'] ?? [],
            'childcategory' => $result['childcategory'] ?? []
        ]);
    }

    public function viewAllBrands(Request $request)
    {
        $result = ViewAllBrands::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view($result['view']);
    }

    public function saveNewBrand(Request $request)
    {
        $result = CreateBrand::execute($request);

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

    public function featureBrand($id)
    {
        $result = ToggleBrandFeature::execute(request(), $id);
        return response()->json($result);
    }

    public function editBrand($slug)
    {
        $result = GetBrandForEdit::execute(request(), $slug);

        if ($result['status'] === 'error') {
            Toastr::error($result['message'], 'Error');
            return redirect()->route('ViewAllBrands');
        }

        return view($result['view'], [
            'data' => $result['data'],
            'categories' => $result['categories'] ?? collect(),
            'subcategories' => $result['subcategories'] ?? collect(),
            'childcategories' => $result['childcategories'] ?? collect()
        ]);
    }

    public function updateBrand(Request $request)
    {
        $result = UpdateBrand::execute($request);

        if ($result['status'] === 'error') {
            if (isset($result['errors'])) {
                return back()->withErrors($result['errors'])->withInput();
            }
            Toastr::warning($result['message'], 'Error');
            return back();
        }

        Toastr::success($result['message'], 'Success');
        return redirect()->route('ViewAllBrands');
    }

    public function rearrangeBrands()
    {
        $result = ViewRearrangeBrands::execute(request());

        return view($result['view'], [
            'brands' => $result['brands'] ?? collect()
        ]);
    }

    public function saveRearrangeBrands(Request $request)
    {
        $result = SaveRearrangeBrands::execute($request);

        Toastr::success($result['message'] ?? 'Brand has been Rerranged', 'Success');
        return redirect()->route('ViewAllBrands');
    }

    public function deleteBrand($slug)
    {
        $result = DeleteBrand::execute(request(), $slug);
        return response()->json($result);
    }
}
