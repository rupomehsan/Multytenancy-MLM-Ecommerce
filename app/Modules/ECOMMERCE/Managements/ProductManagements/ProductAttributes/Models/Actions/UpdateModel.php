<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Database\Models\ProductModel;

class UpdateModel
{
    public static function execute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'brand_id' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->name));
        $slug = preg_replace('!\s+!', '-', $clean);

        ProductModel::where('id', $request->id)->update([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status,
            'slug' => $slug . '-' . time(),
            'updated_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Model Updated'
        ];
    }
}
