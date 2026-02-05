<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;

class ChangeDeliveryMethodAction
{
    public function execute(Request $request): void
    {
        // If Home Delivery selected, compute district-wise delivery charge
        if (isset($request->delivery_method) && intval($request->delivery_method) === Order::DELIVERY_HOME) {
            $districtWiseDeliveryCharge = 0;
            $districtInfo = DB::table('districts')->where('id', $request->shipping_district_id)->first();

            if ($districtInfo) {
                $districtWiseDeliveryCharge = $districtInfo->delivery_charge;
            }

            session(['shipping_charge' => $districtWiseDeliveryCharge]);
            return;
        }

        // For Store Pickup or POS Handover, shipping charge should be zero
        session(['shipping_charge' => 0]);
    }
}
