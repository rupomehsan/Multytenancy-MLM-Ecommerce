<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions\ViewAllColors;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions\CreateColor;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions\GetColorInfo;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions\UpdateColor;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions\DeleteColor;

class ColorController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/ProductAttributes/Colors');
    }

    public function viewAllColors(Request $request)
    {
        $result = ViewAllColors::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view($result['view']);
    }

    public function addNewColor(Request $request)
    {
        $result = CreateColor::execute($request);
        return response()->json([$result['status'] => $result['message']]);
    }

    public function deleteColor($id)
    {
        $result = DeleteColor::execute(request(), $id);
        return response()->json([$result['status'] => $result['message']]);
    }

    public function getColorInfo($id)
    {
        $result = GetColorInfo::execute(request(), $id);

        if ($result['status'] === 'error') {
            return response()->json(['error' => $result['message']]);
        }

        return response()->json($result['data']);
    }

    public function updateColor(Request $request)
    {
        $result = UpdateColor::execute($request);
        return response()->json([$result['status'] => $result['message']]);
    }
}
