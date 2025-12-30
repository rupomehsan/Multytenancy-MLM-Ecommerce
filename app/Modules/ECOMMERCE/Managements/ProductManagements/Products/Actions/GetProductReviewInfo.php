<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductReview;

class GetProductReviewInfo
{
    public static function execute(Request $request, $id)
    {
        $data = ProductReview::where('id', $id)->first();

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
