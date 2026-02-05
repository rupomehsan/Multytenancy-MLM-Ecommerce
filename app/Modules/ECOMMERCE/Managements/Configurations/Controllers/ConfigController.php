<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ViewConfigSetup;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\UpdateConfigSetup;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ViewAllSims;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\DeleteSim;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\GetSimInfo;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\UpdateSimInfo;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\CreateNewSim;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ViewAllDeviceConditions;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\DeleteDeviceCondition;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\GetDeviceConditionInfo;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\UpdateDeviceCondition;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\AddNewDeviceCondition;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ViewRearrangeDeviceCondition;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\SaveRearrangeDeviceCondition;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ViewAllProductWarrenties;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\DeleteProductWarrenty;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\GetProductWarrentyInfo;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\UpdateProductWarrenty;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\AddNewProductWarrenty;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ViewRearrangeWarrenty;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\SaveRearrangeWarrenties;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ViewSmsGateways;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\UpdateSmsGatewayInfo;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ChangeSmsGatewayStatus;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ViewPaymentGateways;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\UpdatePaymentGatewayInfo;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\ChangePaymentGatewayStatus;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/Configurations');
    }

    public function configSetup()
    {
        $result = ViewConfigSetup::execute(request());

        return view('setup', [
            'techConfigs' => $result['techConfigs'] ?? collect(),
            'fashionConfigs' => $result['fashionConfigs'] ?? collect()
        ]);
    }

    public function updateConfigSetup(Request $request)
    {
        $result = UpdateConfigSetup::execute($request);

        Toastr::success($result['message'] ?? 'Config Setup Updated', 'Success');
        return back();
    }

    public function viewAllSims(Request $request)
    {
        $result = ViewAllSims::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view($result['view']);
    }

    public function deleteSim($id)
    {
        $result = DeleteSim::execute(request(), $id);
        return response()->json($result);
    }

    public function getSimInfo($id)
    {
        $result = GetSimInfo::execute(request(), $id);
        return response()->json($result['data'] ?? null);
    }

    public function updateSimInfo(Request $request)
    {
        $result = UpdateSimInfo::execute($request);
        return response()->json($result);
    }

    public function createNewSim(Request $request)
    {
        $result = CreateNewSim::execute($request);

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 422);
        }

        return response()->json($result);
    }

    public function viewAllDeviceConditions(Request $request)
    {
        $result = ViewAllDeviceConditions::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view($result['view']);
    }

    public function deleteDeviceCondition($id)
    {
        $result = DeleteDeviceCondition::execute(request(), $id);
        return response()->json($result);
    }

    public function getDeviceConditionInfo($id)
    {
        $result = GetDeviceConditionInfo::execute(request(), $id);
        return response()->json($result['data'] ?? null);
    }

    public function updateDeviceCondition(Request $request)
    {
        $result = UpdateDeviceCondition::execute($request);
        return response()->json($result);
    }

    public function addNewDeviceCondition(Request $request)
    {
        $result = AddNewDeviceCondition::execute($request);

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 422);
        }

        return response()->json($result);
    }

    public function rearrangeDeviceCondition()
    {
        $result = ViewRearrangeDeviceCondition::execute(request());

        return view($result['view'], [
            'conditions' => $result['conditions'] ?? collect()
        ]);
    }

    public function saveRearrangeDeviceCondition(Request $request)
    {
        $result = SaveRearrangeDeviceCondition::execute($request);

        Toastr::success($result['message'] ?? 'Device Conditions are Rerranged', 'Success');
        return redirect('/view/all/device/conditions');
    }

    public function viewAllProductWarrenties(Request $request)
    {
        $result = ViewAllProductWarrenties::execute($request);

        if ($request->ajax()) {
            return $result;
        }

        return view($result['view']);
    }

    public function deleteProductWarrenty($id)
    {
        $result = DeleteProductWarrenty::execute(request(), $id);
        return response()->json($result);
    }

    public function getProductWarrentyInfo($id)
    {
        $result = GetProductWarrentyInfo::execute(request(), $id);
        return response()->json($result['data'] ?? null);
    }

    public function updateProductWarrenty(Request $request)
    {
        $result = UpdateProductWarrenty::execute($request);
        return response()->json($result);
    }

    public function addNewProductWarrenty(Request $request)
    {
        $result = AddNewProductWarrenty::execute($request);

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 422);
        }

        return response()->json($result);
    }

    public function rearrangeWarrenty()
    {
        $result = ViewRearrangeWarrenty::execute(request());

        return view($result['view'], [
            'warrenties' => $result['warrenties'] ?? collect()
        ]);
    }

    public function saveRearrangeWarrenties(Request $request)
    {
        $result = SaveRearrangeWarrenties::execute($request);

        Toastr::success($result['message'] ?? 'Product Warrenties are Rerranged', 'Success');
        return redirect('/view/all/warrenties');
    }

    public function viewSmsGateways()
    {
        $result = ViewSmsGateways::execute(request());

        return view($result['view'], [
            'gateways' => $result['gateways'] ?? collect()
        ]);
    }

    public function updateSmsGatewayInfo(Request $request)
    {
        $result = UpdateSmsGatewayInfo::execute($request);

        Toastr::success($result['message'] ?? 'Info Updated', 'Success');
        return back();
    }

    public function changeGatewayStatus($provider)
    {
        $result = ChangeSmsGatewayStatus::execute(request(), $provider);
        return response()->json($result);
    }

    public function viewPaymentGateways()
    {
        $result = ViewPaymentGateways::execute(request());

        return view($result['view'], [
            'gateways' => $result['gateways'] ?? collect()
        ]);
    }

    public function updatePaymentGatewayInfo(Request $request)
    {
        $result = UpdatePaymentGatewayInfo::execute($request);

        if ($result['status'] == 'success') {
            Toastr::success('Payment Gateway Info Updated', 'Updated Successfully');
        } else {
            Toastr::error($result['message'] ?? 'Failed to Update', 'Error');
        }

        return back();
    }

    public function changePaymentGatewayStatus($provider)
    {
        $result = ChangePaymentGatewayStatus::execute(request(), $provider);
        return response()->json($result);
    }
}
