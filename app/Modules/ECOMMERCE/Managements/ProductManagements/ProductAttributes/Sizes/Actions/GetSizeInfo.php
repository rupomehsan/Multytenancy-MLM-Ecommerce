<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;

class GetSizeInfo
{
    public static function execute(Request $request, $id)
    {
        $data = ProductSize::where('id', $id)->first();

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Size not found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
