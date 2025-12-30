<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;

class GetModelFormData
{
    public static function execute(Request $request)
    {
        $brands = Brand::getDropDownList('name');

        return [
            'status' => 'success',
            'data' => [
                'brands' => $brands
            ]
        ];
    }
}
