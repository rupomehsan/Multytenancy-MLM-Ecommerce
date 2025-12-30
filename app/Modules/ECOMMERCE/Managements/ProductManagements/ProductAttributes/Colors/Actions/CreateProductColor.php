<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;

class CreateProductColor
{
    public static function execute(Request $request)
    {
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

        Color::create([
            'name' => $request->name,
            'code' => $request->code,
            'created_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Added successfully!'
        ];
    }
}
