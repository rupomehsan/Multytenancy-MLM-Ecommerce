<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetDistrictThanasByNameAction
{
    public function execute(Request $request): array
    {
        $districtName = $request->district_id;
        $districtWiseDeliveryCharge = 0;

        $districtInfo = DB::table('districts')->where('name', $districtName)->first();

        if ($districtInfo) {
            $districtWiseDeliveryCharge = $districtInfo->delivery_charge;
        }

        session(['shipping_charge' => $districtWiseDeliveryCharge]);

        $thanas = DB::table('upazilas')
            ->leftJoin('districts', 'upazilas.district_id', 'districts.id')
            ->where("districts.name", $districtName)
            ->select('upazilas.name', 'upazilas.id')
            ->orderBy('upazilas.name', 'asc')
            ->get();

        return [
            'data' => $thanas,
            'delivery_charge' => $districtWiseDeliveryCharge
        ];
    }
}
