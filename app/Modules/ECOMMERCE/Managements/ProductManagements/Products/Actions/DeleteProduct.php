<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductImage;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductVariant;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductReview;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductQuestionAnswer;
use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\OrderDetails;

class DeleteProduct
{
    public static function execute(Request $request, $slug)
    {
        $data = Product::where('slug', $slug)->first();

        $orderExists = OrderDetails::where('product_id', $data->id)->first();
        if ($orderExists) {
            return [
                'status' => 'error',
                'message' => 'Product cannot be deleted',
                'data' => 0
            ];
        }

        if ($data->image) {
            if (file_exists(public_path($data->image)) && $data->is_demo == 0) {
                unlink(public_path($data->image));
            }
        }

        $gallery = ProductImage::where('product_id', $data->id)->get();
        if (count($gallery) > 0 && $data->is_demo == 0) {
            foreach ($gallery as $img) {
                if ($img->image && file_exists(public_path($img->image))) {
                    unlink(public_path($img->image));
                }
                $img->delete();
            }
        }

        $variants = ProductVariant::where('product_id', $data->id)->orderBy('id', 'asc')->get();
        if (count($variants) > 0 && $data->is_demo == 0) {
            foreach ($variants as $img) {
                if ($img->image && file_exists(public_path($img->image))) {
                    unlink(public_path($img->image));
                }
                $img->delete();
            }
        }

        ProductQuestionAnswer::where('product_id', $data->id)->delete();
        ProductReview::where('product_id', $data->id)->delete();
        $data->delete();

        return [
            'status' => 'success',
            'message' => 'Product deleted successfully.',
            'data' => 1
        ];
    }
}
