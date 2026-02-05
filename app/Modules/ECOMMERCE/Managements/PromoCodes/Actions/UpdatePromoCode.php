<?php

namespace App\Modules\ECOMMERCE\Managements\PromoCodes\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Modules\ECOMMERCE\Managements\PromoCodes\Database\Models\PromoCode;

class UpdatePromoCode
{
    public static function execute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'type' => 'required',
            'value' => 'required',
            'code' => 'required',
            'effective_date' => 'required',
            'expire_date' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        if ($request->type == 2 && $request->value > 100) {
            return [
                'status' => 'error',
                'message' => 'Percentage Cannot be Greater than 100'
            ];
        }

        if (strtotime(str_replace("/", "-", $request->effective_date)) > strtotime(str_replace("/", "-", $request->expire_date))) {
            return [
                'status' => 'error',
                'message' => 'Effective Date Cannot be greater than Expiry Date'
            ];
        }

        $expireDateTimestamp = strtotime(str_replace("/", "-", $request->expire_date));
        if ($expireDateTimestamp && $expireDateTimestamp < now()->timestamp) {
            return [
                'status' => 'error',
                'message' => 'The date is expired. You can\'t change the status.'
            ];
        }

        $data = PromoCode::where('slug', $request->slug)->first();

        $icon = $data->icon;
        if ($request->hasFile('icon')) {
            $get_image = $request->file('icon');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('uploads/promoImages/');
            $get_image->move($location, $image_name);
            $icon = "uploads/promoImages/" . $image_name;
        }

        PromoCode::where('slug', $request->slug)->update([
            'icon' => $icon,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->value,
            'minimum_order_amount' => $request->minimum_order_amount,
            'code' => $request->code,
            'effective_date' => date("Y-m-d", strtotime(str_replace("/", "-", $request->effective_date))),
            'expire_date' => date("Y-m-d", strtotime(str_replace("/", "-", $request->expire_date))),
            'status' => $request->status,
        ]);

        return [
            'status' => 'success',
            'message' => 'Promo Code Updated'
        ];
    }
}
