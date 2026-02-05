<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;

class DeleteBrand
{
    public static function execute(Request $request, $slug): array
    {
        try {
            $data = Brand::where('slug', $slug)->first();

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Brand not found.'
                ];
            }

            if ($data->logo && file_exists(public_path($data->logo))) {
                unlink(public_path($data->logo));
            }

            if ($data->banner && file_exists(public_path($data->banner))) {
                unlink(public_path($data->banner));
            }

            Product::where('brand_id', $data->id)->delete();
            $data->delete();

            return [
                'status' => 'success',
                'message' => 'Brand Deleted Successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
