<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductImage;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductVariant;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductReview;

class RemoveDemoProducts
{
    public static function execute(Request $request)
    {
        ini_set('max_execution_time', 3600);

        $products = Product::where('is_demo', 1)->get();
        foreach ($products as $product) {
            ProductImage::where('product_id', $product->id)->delete();
            ProductVariant::where('product_id', $product->id)->delete();
            ProductReview::where('product_id', $product->id)->delete();
            $product->delete();
        }

        return [
            'status' => 'success',
            'message' => 'Successfully Removed Demo Products'
        ];
    }
}
