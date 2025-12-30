<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;

class RemoveCouponAction
{
    public function execute(Request $request): array
    {
        session()->forget('coupon');
        session()->forget('pos_discount');

        return [
            'status' => 1,
            'message' => 'Coupon removed'
        ];
    }
}
