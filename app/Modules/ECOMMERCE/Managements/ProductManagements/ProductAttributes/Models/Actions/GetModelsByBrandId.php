<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Database\Models\ProductModel;

class GetModelsByBrandId
{
    public static function execute(Request $request)
    {
        $data = ProductModel::where("brand_id", $request->brand_id)
            ->select('name', 'id')
            ->get();

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
