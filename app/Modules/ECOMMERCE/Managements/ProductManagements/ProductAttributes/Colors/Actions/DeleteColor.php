<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;

class DeleteColor
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

        Color::where('id', $id)->delete();

        return [
            'status' => 'success',
            'message' => 'Delete Successfully.'
        ];
    }
}
