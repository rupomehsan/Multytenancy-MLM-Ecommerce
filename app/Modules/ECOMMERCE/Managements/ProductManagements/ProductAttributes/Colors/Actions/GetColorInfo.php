<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;

class GetColorInfo
{
    public static function execute(Request $request, $id)
    {
        $data = Color::where('id', $id)->first();

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Color not found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
