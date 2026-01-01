<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Actions\ViewAllSizes;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Actions\CreateSize;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Actions\GetSizeInfo;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Actions\UpdateSize;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Actions\DeleteSize;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Actions\GetRearrangeSizes;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Actions\SaveRearrangeSizes;


class ProductSizeController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/ProductAttributes/Sizes');
    }

    public function viewAllSizes(Request $request)
    {
        $result = ViewAllSizes::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view($result['view']);
    }

    public function deleteSize($id)
    {
        $result = DeleteSize::execute(request(), $id);
        return response()->json([$result['status'] => $result['message']]);
    }

    public function getSizeInfo($id)
    {
        $result = GetSizeInfo::execute(request(), $id);

        if ($result['status'] === 'error') {
            return response()->json(['error' => $result['message']]);
        }

        return response()->json($result['data']);
    }

    public function updateSizeInfo(Request $request)
    {
        $result = UpdateSize::execute($request);
        return response()->json([$result['status'] => $result['message']]);
    }

    public function createNewSize(Request $request)
    {
        $result = CreateSize::execute($request);
        return response()->json([$result['status'] => $result['message']]);
    }

    public function rearrangeSize(Request $request)
    {
        $result = GetRearrangeSizes::execute($request);
        return view($result['view'], ['data' => $result['data']]);
    }

    public function saveRearrangedSizes(Request $request)
    {
        $result = SaveRearrangeSizes::execute($request);
        Toastr::success($result['message'], 'Success');
        return redirect()->route('ViewAllSizes');
    }
}
