<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ViewAllStorages;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\AddNewStorage;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\DeleteStorage;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\GetStorageInfo;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\UpdateStorage;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ViewRearrangeStorage;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\SaveRearrangeStorage;

class StorageController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/Configurations');
    }

    public function viewAllStorages(Request $request)
    {
        $result = ViewAllStorages::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view($result['view']);
    }

    public function addNewStorage(Request $request)
    {
        $result = AddNewStorage::execute($request);

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 422);
        }

        return response()->json($result);
    }

    public function deleteStorage($id)
    {
        $result = DeleteStorage::execute(request(), $id);
        return response()->json($result);
    }

    public function getStorageInfo($id)
    {
        $result = GetStorageInfo::execute(request(), $id);
        return response()->json($result['data'] ?? null);
    }

    public function updateStorage(Request $request)
    {
        $result = UpdateStorage::execute($request);

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 422);
        }

        return response()->json($result);
    }

    public function rearrangeStorage()
    {
        $result = ViewRearrangeStorage::execute(request());

        return view($result['view'], [
            'storages' => $result['storages'] ?? collect()
        ]);
    }

    public function saveRearrangeStorage(Request $request)
    {
        $result = SaveRearrangeStorage::execute($request);

        Toastr::success($result['message'] ?? 'Storages has been Rerranged', 'Success');
        return redirect('/view/all/storages');
    }
}
