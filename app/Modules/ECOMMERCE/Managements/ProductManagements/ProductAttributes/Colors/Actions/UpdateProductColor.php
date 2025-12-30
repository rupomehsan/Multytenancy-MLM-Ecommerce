<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;

class UpdateProductColor
{
    public static function execute(Request $request)
    {
        $data = Color::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $data->update([
            'name' => $request->name ?? $data->name,
            'code' => $request->code ?? $data->code,
            'created_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Updated Successfully',
            'data' => $data
        ];
    }
}
