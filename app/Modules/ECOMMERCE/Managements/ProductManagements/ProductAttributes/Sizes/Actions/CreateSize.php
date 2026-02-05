<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;

class CreateSize
{
    public static function execute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        ProductSize::insert([
            'name' => $request->name,
            'status' => 1,
            'slug' => time() . Str::random(5),
            'created_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Created successfully.'
        ];
    }
}
