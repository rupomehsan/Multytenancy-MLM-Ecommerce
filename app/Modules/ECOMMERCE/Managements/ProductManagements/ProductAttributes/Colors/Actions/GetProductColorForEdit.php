<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;

class GetProductColorForEdit
{
    public static function execute(Request $request, $slug)
    {
        $data = Color::where('id', $slug)->first();

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Product Color not found'
            ];
        }

        return [
            'status' => 'success',
            'view' => 'edit',
            'data' => $data
        ];
    }
}
