<?php

namespace App\Modules\ECOMMERCE\Managements\POS\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplyCouponAction
{
    public function execute(Request $request): array
    {
        $couponCode = $request->coupon_code;
        $couponInfo = DB::table('promo_codes')->where('code', $couponCode)->first();

        if (!$couponInfo) {
            return [
                'status' => 0,
                'message' => "Coupon Not Found"
            ];
        }

        if ($couponInfo->effective_date && $couponInfo->effective_date > date("Y-m-d")) {
            return [
                'status' => 0,
                'message' => "Coupon is not Applicable"
            ];
        }

        if ($couponInfo->expire_date && $couponInfo->expire_date < date("Y-m-d")) {
            return [
                'status' => 0,
                'message' => "Coupon is Expired"
            ];
        }

        $subTotal = $this->calculateSubTotal();

        if ($couponInfo->minimum_order_amount && $couponInfo->minimum_order_amount > $subTotal) {
            return [
                'status' => 0,
                'message' => "Minimum Amount is not Matched"
            ];
        }

        $discount = $this->calculateDiscount($couponInfo, $subTotal);

        if ($discount > $subTotal) {
            return [
                'status' => 0,
                'message' => "Discount Cannot be greater than Order Amount"
            ];
        }

        session([
            'coupon' => $couponCode,
            'pos_discount' => $discount
        ]);

        return [
            'status' => 1,
            'message' => "Coupon Applied",
            'coupon_discount' => $discount
        ];
    }

    private function calculateSubTotal(): float
    {
        $subTotal = 0;
        foreach ((array) session('cart') as $id => $details) {
            $subTotal += ($details['price'] * $details['quantity']);
        }
        return $subTotal;
    }

    private function calculateDiscount($couponInfo, float $subTotal): float
    {
        if ($couponInfo->type == 1) {
            return $couponInfo->value;
        }

        return ($subTotal * $couponInfo->value) / 100;
    }
}
