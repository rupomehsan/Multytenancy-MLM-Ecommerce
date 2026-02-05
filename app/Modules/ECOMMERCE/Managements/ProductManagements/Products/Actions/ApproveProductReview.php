<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductReview;

class ApproveProductReview
{
    public static function execute(Request $request, $slug)
    {
        ProductReview::where('slug', $slug)->update([
            'status' => 1,
            'updated_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Product Review Approved Successfully.'
        ];
    }
}
