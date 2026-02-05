<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Models\Unit;

class GetUnitInfo
{
    public static function execute(Request $request, $id)
    {
        $data = Unit::where('id', $id)->first();

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Unit not found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
