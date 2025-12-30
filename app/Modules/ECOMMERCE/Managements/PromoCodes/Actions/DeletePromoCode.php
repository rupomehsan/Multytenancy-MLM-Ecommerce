<?php

namespace App\Modules\ECOMMERCE\Managements\PromoCodes\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\PromoCodes\Database\Models\PromoCode;

class DeletePromoCode
{
    public static function execute(Request $request, $slug)
    {
        $data = PromoCode::where('slug', $slug)->first();

        if ($data->icon) {
            if (file_exists(public_path($data->icon))) {
                unlink(public_path($data->icon));
            }
        }

        PromoCode::where('slug', $slug)->delete();

        return [
            'status' => 'success',
            'message' => 'Category deleted successfully.'
        ];
    }
}
