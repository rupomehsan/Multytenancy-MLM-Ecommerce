<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Models\Flag;

class ToggleFlagFeature
{
    public static function execute(Request $request, $id)
    {
        $data = Flag::where('id', $id)->first();

        if (!$data) {
            return [
                'status' => 'error',
                'message' => 'Flag not found'
            ];
        }

        if ($data->featured == 0) {
            $data->featured = 1;
        } else {
            $data->featured = 0;
        }

        $data->save();

        return [
            'status' => 'success',
            'message' => 'Status Changed successfully.'
        ];
    }
}
