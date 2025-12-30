<?php

namespace App\Modules\ECOMMERCE\Managements\PromoCodes\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\PromoCodes\Database\Models\PromoCode;

class GetPromoCodeForEdit
{
    public static function execute(Request $request, $slug)
    {
        $data = PromoCode::where('slug', $slug)->first();

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Promo Code not found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
