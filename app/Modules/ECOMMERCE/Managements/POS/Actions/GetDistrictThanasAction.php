<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetDistrictThanasAction
{
    public function execute(Request $request): array
    {
        $districtId = $request->district_id;
        $districtWiseDeliveryCharge = 0;

        $districtInfo = DB::table('districts')->where('id', $districtId)->first();

        if ($districtInfo) {
            $districtWiseDeliveryCharge = $districtInfo->delivery_charge;
        }

        session(['shipping_charge' => $districtWiseDeliveryCharge]);

        $thanas = DB::table('upazilas')
            ->where("district_id", $districtId)
            ->select('name', 'id')
            ->orderBy('name', 'asc')
            ->get();

        return [
            'data' => $thanas,
            'delivery_charge' => $districtWiseDeliveryCharge
        ];
    }
}
