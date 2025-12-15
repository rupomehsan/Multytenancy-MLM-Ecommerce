<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use DB;

use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\ConfigSetup;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\DeviceCondition;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Models\Flag;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductWarrenty;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Models\Unit;
use App\Models\Sim;


use App\Modules\ECOMMERCE\Managements\SmsService\Database\Models\SmsGateway;
use App\Models\PaymentGateway;
use App\Modules\ECOMMERCE\Managements\Configurations\Actions\UpdatePaymentGatewayInfo;
use App\Modules\Managements\MLM\Settings\Actions\Update;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/Configurations');
    }
    public function configSetup()
    {
        $techConfigs = ConfigSetup::orderBy('industry', 'desc')->get();
        $fashionConfigs = ConfigSetup::orderBy('industry', 'desc')->get();
        return view('setup', compact('techConfigs', 'fashionConfigs'));
    }

    public function updateConfigSetup(Request $request)
    {

        $configArray = array();

        if (isset($request->config_setup)) {
            foreach ($request->config_setup as $configSetup) {
                $configArray[] = $configSetup;
                ConfigSetup::where('code', $configSetup)->update([
                    'status' => 1,
                    'updated_at' => Carbon::now()
                ]);
            }
        }


        ConfigSetup::whereNotIn('code', $configArray)->update([
            'status' => 0,
            'updated_at' => Carbon::now()
        ]);

        Toastr::success('Config Setup Updated', 'Success');
        return back();
    }





    // sim methods
    public function viewAllSims(Request $request)
    {
        if ($request->ajax()) {

            $data = Sim::orderBy('id', 'desc')->get();

            return Datatables::of($data)
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="mb-1 btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('sim');
    }

    public function deleteSim($id)
    {
        Sim::where('id', $id)->delete();
        return response()->json(['success' => 'Deleted successfully.']);
    }

    public function getSimInfo($id)
    {
        $data = Sim::where('id', $id)->first();
        return response()->json($data);
    }

    public function updateSimInfo(Request $request)
    {
        Sim::where('id', $request->sim_id)->update([
            'name' => $request->name,
            'updated_at' => Carbon::now()
        ]);
        return response()->json(['success' => 'Updated successfully.']);
    }

    public function createNewSim(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        Sim::insert([
            'name' => $request->name,
            'created_at' => Carbon::now()
        ]);
        return response()->json(['success' => 'Updated successfully.']);
    }


    // config route for device condition
    public function viewAllDeviceConditions(Request $request)
    {
        if ($request->ajax()) {

            $data = DeviceCondition::orderBy('serial', 'asc')->get();

            return Datatables::of($data)
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="mb-1 btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('device_condition');
    }

    public function deleteDeviceCondition($id)
    {
        DeviceCondition::where('id', $id)->delete();
        return response()->json(['success' => 'Deleted successfully.']);
    }

    public function getDeviceConditionInfo($id)
    {
        $data = DeviceCondition::where('id', $id)->first();
        return response()->json($data);
    }

    public function updateDeviceCondition(Request $request)
    {
        DeviceCondition::where('id', $request->device_condition_id)->update([
            'name' => $request->name,
            'updated_at' => Carbon::now()
        ]);
        return response()->json(['success' => 'Updated successfully.']);
    }

    public function addNewDeviceCondition(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        DeviceCondition::insert([
            'name' => $request->name,
            'created_at' => Carbon::now()
        ]);
        return response()->json(['success' => 'Created successfully.']);
    }

    public function rearrangeDeviceCondition()
    {
        $conditions = DeviceCondition::orderBy('serial', 'asc')->get();
        return view('rearrangeDeviceCondition', compact('conditions'));
    }

    public function saveRearrangeDeviceCondition(Request $request)
    {
        $sl = 1;
        foreach ($request->id as $id) {
            DeviceCondition::where('id', $id)->update([
                'serial' => $sl
            ]);
            $sl++;
        }
        Toastr::success('Device Conditions are Rerranged', 'Success');
        return redirect('/view/all/device/conditions');
    }




    // config route for product warrenty
    public function viewAllProductWarrenties(Request $request)
    {
        if ($request->ajax()) {

            $data = ProductWarrenty::orderBy('serial', 'asc')->get();

            return Datatables::of($data)
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="mb-1 btn-sm btn-warning rounded editBtn"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('product_warrenty');
    }

    public function deleteProductWarrenty($id)
    {
        ProductWarrenty::where('id', $id)->delete();
        return response()->json(['success' => 'Deleted successfully.']);
    }

    public function getProductWarrentyInfo($id)
    {
        $data = ProductWarrenty::where('id', $id)->first();
        return response()->json($data);
    }

    public function updateProductWarrenty(Request $request)
    {
        ProductWarrenty::where('id', $request->product_warrenty_id)->update([
            'name' => $request->name,
            'updated_at' => Carbon::now()
        ]);
        return response()->json(['success' => 'Updated successfully.']);
    }

    public function addNewProductWarrenty(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        ProductWarrenty::insert([
            'name' => $request->name,
            'created_at' => Carbon::now()
        ]);
        return response()->json(['success' => 'Created successfully.']);
    }
    public function rearrangeWarrenty()
    {
        $warrenties = ProductWarrenty::orderBy('serial', 'asc')->get();
        return view('rearrangeWarrenty', compact('warrenties'));
    }
    public function saveRearrangeWarrenties(Request $request)
    {
        $sl = 1;
        foreach ($request->id as $id) {
            ProductWarrenty::where('id', $id)->update([
                'serial' => $sl
            ]);
            $sl++;
        }
        Toastr::success('Product Warrenties are Rerranged', 'Success');
        return redirect('/view/all/warrenties');
    }




    public function viewSmsGateways()
    {
        $gateways = SmsGateway::orderBy('id', 'asc')->get();
        return view('sms_gateway', compact('gateways'));
    }

    public function updateSmsGatewayInfo(Request $request)
    {
        $provider = $request->provider;

        DB::table('sms_gateways')->update([
            'status' => 0,
            'updated_at' => Carbon::now()
        ]);

        if ($provider == 'elitbuzz') { //ID 1 => Elitbuzz
            SmsGateway::where('id', 1)->update([
                'api_endpoint' => $request->api_endpoint,
                'api_key' => $request->api_key,
                'sender_id' => $request->sender_id,
                'status' => 1,
                'updated_at' => Carbon::now()
            ]);
        }

        if ($provider == 'revesms') { //ID 2 => Revesms
            SmsGateway::where('id', 2)->update([
                'api_endpoint' => $request->api_endpoint,
                'api_key' => $request->api_key,
                'secret_key' => $request->secret_key,
                'sender_id' => $request->sender_id,
                'status' => 1,
                'updated_at' => Carbon::now()
            ]);
        }

        Toastr::success('Info Updated', 'Success');
        return back();
    }

    public function changeGatewayStatus($provider)
    {

        DB::table('sms_gateways')->update([
            'status' => 0,
            'updated_at' => Carbon::now()
        ]);

        if ($provider == 'elitbuzz') { //ID 1 => Elitbuzz
            SmsGateway::where('id', 1)->update([
                'status' => 1,
                'updated_at' => Carbon::now()
            ]);
        }

        if ($provider == 'revesms') { //ID 2 => Revesms
            SmsGateway::where('id', 2)->update([
                'status' => 1,
                'updated_at' => Carbon::now()
            ]);
        }

        return response()->json(['success' => 'Updated Successfully.']);
    }


    // payment gateway
    public function viewPaymentGateways()
    {
        $gateways = PaymentGateway::orderBy('id', 'asc')->get();
        return view('payment_gateway', compact('gateways'));
    }

    public function updatePaymentGatewayInfo(Request $request)
    {

        $data = UpdatePaymentGatewayInfo::execute($request);
        if ($data['status'] == 'success') {
            Toastr::success('Payment Gateway Info Updated', 'Updated Successfully');
            return back();
        } else {
            Toastr::error($data['message'], 'Failed to Update');
            return back();
        }
    }

    public function changePaymentGatewayStatus($provider)
    {

        if ($provider == 'ssl_commerz') { //ID 1 => ssl_commerz
            $info = PaymentGateway::where('id', 1)->first();

            PaymentGateway::where('id', 1)->update([
                'status' => $info->status == 1 ? 0 : 1,
                'updated_at' => Carbon::now()
            ]);
        }

        if ($provider == 'stripe') { //ID 2 => stripe
            $info = PaymentGateway::where('id', 2)->first();

            PaymentGateway::where('id', 2)->update([
                'status' => $info->status == 1 ? 0 : 1,
                'updated_at' => Carbon::now()
            ]);
        }

        if ($provider == 'bkash') { //ID 3 => bkash
            $info = PaymentGateway::where('id', 3)->first();

            PaymentGateway::where('id', 3)->update([
                'status' => $info->status == 1 ? 0 : 1,
                'updated_at' => Carbon::now()
            ]);
        }

        if ($provider == 'amar_pay') { //ID 4 => amar_pay
            $info = PaymentGateway::where('id', 4)->first();

            PaymentGateway::where('id', 4)->update([
                'status' => $info->status == 1 ? 0 : 1,
                'updated_at' => Carbon::now()
            ]);
        }

        return response()->json(['success' => 'Updated Successfully.']);
    }
}
