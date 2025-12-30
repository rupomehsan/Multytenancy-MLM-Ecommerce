<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\DeviceCondition;

class UpdateDeviceCondition
{
    public static function execute(Request $request): array
    {
        try {
            DeviceCondition::where('id', $request->device_condition_id)->update([
                'name' => $request->name,
                'updated_at' => Carbon::now()
            ]);

            return [
                'status' => 'success',
                'message' => 'Updated successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
