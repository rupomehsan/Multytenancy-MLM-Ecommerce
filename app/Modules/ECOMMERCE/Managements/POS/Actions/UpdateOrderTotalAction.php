<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;

class UpdateOrderTotalAction
{
    public function execute(Request $request): void
    {
        $shipping_charge = $request->shipping_charge ?? $request->route('shipping_charge');
        $discount = $request->discount ?? $request->route('discount');

        $shipping_charge = is_numeric($shipping_charge) ? $shipping_charge : 0;
        $discount = is_numeric($discount) ? $discount : 0;

        session(['shipping_charge' => $shipping_charge]);
        session(['discount' => $discount]);
    }
}
