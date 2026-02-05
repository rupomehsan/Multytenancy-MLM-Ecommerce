<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\StorageType;

class UpdateStorage
{
    public static function execute(Request $request): array
    {
        try {
            $validator = Validator::make($request->all(), [
                'ram' => ['required', 'string', 'max:255'],
                'rom' => ['required', 'string', 'max:255'],
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'errors' => $validator->errors()
                ];
            }

            StorageType::where('id', $request->storage_type_id)->update([
                'ram' => $request->ram,
                'rom' => $request->rom,
                'status' => $request->status,
                'updated_at' => Carbon::now()
            ]);

            return [
                'status' => 'success',
                'message' => 'Updated Successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
