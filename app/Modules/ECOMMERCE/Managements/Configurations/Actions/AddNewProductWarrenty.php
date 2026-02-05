<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductWarrenty;

class AddNewProductWarrenty
{
    public static function execute(Request $request): array
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'errors' => $validator->errors()
                ];
            }

            ProductWarrenty::insert([
                'name' => $request->name,
                'created_at' => Carbon::now()
            ]);

            return [
                'status' => 'success',
                'message' => 'Created successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
