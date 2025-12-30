<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Actions\ViewAllFlags;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Actions\CreateFlag;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Actions\GetFlagInfo;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Actions\UpdateFlag;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Actions\ToggleFlagFeature;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Actions\DeleteFlag;


class FlagController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/ProductManagements/ProductAttributes/Flags');
    }

    public function viewAllFlags(Request $request)
    {
        $result = ViewAllFlags::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view($result['view']);
    }

    public function deleteFlag($slug)
    {
        $result = DeleteFlag::execute(request(), $slug);
        return response()->json([$result['status'] => $result['message']]);
    }

    public function getFlagInfo($slug)
    {
        $result = GetFlagInfo::execute(request(), $slug);

        if ($result['status'] === 'error') {
            return response()->json(['error' => $result['message']]);
        }

        return response()->json($result['data']);
    }

    public function updateFlagInfo(Request $request)
    {
        $result = UpdateFlag::execute($request);
        return response()->json([$result['status'] => $result['message']]);
    }

    public function createNewFlag(Request $request)
    {
        $result = CreateFlag::execute($request);
        return response()->json([$result['status'] => $result['message']]);
    }

    public function featureFlag($id)
    {
        $result = ToggleFlagFeature::execute(request(), $id);
        return response()->json([$result['status'] => $result['message']]);
    }
}
