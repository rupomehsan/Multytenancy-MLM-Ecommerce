<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Actions\ViewAllUnits;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Actions\CreateUnit;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Actions\GetUnitInfo;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Actions\UpdateUnit;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Actions\DeleteUnit;



class UnitController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/ProductAttributes/Units');
    }

    public function viewAllUnits(Request $request)
    {
        $result = ViewAllUnits::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view($result['view']);
    }

    public function deleteUnit($id)
    {
        $result = DeleteUnit::execute(request(), $id);
        return response()->json([$result['status'] => $result['message']]);
    }

    public function getUnitInfo($id)
    {
        $result = GetUnitInfo::execute(request(), $id);

        if ($result['status'] === 'error') {
            return response()->json(['error' => $result['message']]);
        }

        return response()->json($result['data']);
    }

    public function updateUnitInfo(Request $request)
    {
        $result = UpdateUnit::execute($request);
        return response()->json([$result['status'] => $result['message']]);
    }

    public function createNewUnit(Request $request)
    {
        $result = CreateUnit::execute($request);
        return response()->json([$result['status'] => $result['message']]);
    }
}
