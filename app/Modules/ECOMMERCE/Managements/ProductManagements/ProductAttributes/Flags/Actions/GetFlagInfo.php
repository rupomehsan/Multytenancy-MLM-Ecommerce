<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Models\Flag;

class GetFlagInfo
{
    public static function execute(Request $request, $slug)
    {
        $data = Flag::where('slug', $slug)->first();

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Flag not found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
