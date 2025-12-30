<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\DeviceCondition;

class GetDeviceConditionInfo
{
    public static function execute(Request $request, $id)
    {
        try {
            $data = DeviceCondition::where('id', $id)->first();

            return [
                'status' => 'success',
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
