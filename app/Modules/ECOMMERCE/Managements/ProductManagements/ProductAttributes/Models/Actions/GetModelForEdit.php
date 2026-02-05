<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Database\Models\ProductModel;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;

class GetModelForEdit
{
    public static function execute(Request $request, $slug)
    {
        $data = ProductModel::where('slug', $slug)->first();

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Model not found'
            ];
        }

        $brands = Brand::getDropDownList('name', $data->brand_id);

        return [
            'status' => 'success',
            'data' => [
                'data' => $data,
                'brands' => $brands
            ]
        ];
    }
}
