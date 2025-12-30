<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions\GetProductColorFormData;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions\CreateProductColor;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions\ViewAllProductColors;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions\GetProductColorForEdit;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions\UpdateProductColor;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions\DeleteProductColor;

class ProductColorController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductAttributes/Colors');
    }

    public function addNewProductColor()
    {
        $result = GetProductColorFormData::execute(request());
        return view($result['view']);
    }

    public function saveNewProductColor(Request $request)
    {
        $result = CreateProductColor::execute($request);

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

    public function viewAllProductColor(Request $request)
    {
        $result = ViewAllProductColors::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view($result['view']);
    }

    public function editProductColor($slug)
    {
        $result = GetProductColorForEdit::execute(request(), $slug);

        if ($result['status'] === 'error') {
            Toastr::error($result['message'], 'Error');
            return redirect('/view/all/product-color');
        }

        return view($result['view'], ['data' => $result['data']]);
    }

    public function updateProductColor(Request $request)
    {
        $result = UpdateProductColor::execute($request);

        if ($result['status'] === 'error') {
            if (isset($result['errors'])) {
                return back()->withErrors($result['errors'])->withInput();
            }
            Toastr::error($result['message'], 'Error');
            return back();
        }

        Toastr::success($result['message'], 'Success!');
        return view('edit', ['data' => $result['data']]);
    }

    public function deleteProductColor($slug)
    {
        $result = DeleteProductColor::execute(request(), $slug);
        return response()->json([
            $result['status'] => $result['message'],
            'data' => $result['data']
        ]);
    }
}
