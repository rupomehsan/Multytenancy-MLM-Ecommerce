<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;

class DeleteProductColor
{
    public static function execute(Request $request, $slug)
    {
        $data = Color::where('id', $slug)->first();

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Product Color not found',
                'data' => 0
            ];
        }

        $data->delete();

        return [
            'status' => 'success',
            'message' => 'Deleted successfully!',
            'data' => 1
        ];
    }
}
