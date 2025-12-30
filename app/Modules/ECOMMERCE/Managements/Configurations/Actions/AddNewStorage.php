<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\StorageType;

class AddNewStorage
{
    public static function execute(Request $request): array
    {
        try {
            $validator = Validator::make($request->all(), [
                'ram' => ['required', 'string', 'max:255'],
                'rom' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'errors' => $validator->errors()
                ];
            }

            StorageType::insert([
                'ram' => $request->ram,
                'rom' => $request->rom,
                'status' => 1,
                'slug' => Str::random(5) . time(),
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
