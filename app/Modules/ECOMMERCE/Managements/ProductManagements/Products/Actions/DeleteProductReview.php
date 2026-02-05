<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductReview;

class DeleteProductReview
{
    public static function execute(Request $request, $slug)
    {
        ProductReview::where('slug', $slug)->delete();

        return [
            'status' => 'success',
            'message' => 'Product Review Deleted Successfully.'
        ];
    }
}
