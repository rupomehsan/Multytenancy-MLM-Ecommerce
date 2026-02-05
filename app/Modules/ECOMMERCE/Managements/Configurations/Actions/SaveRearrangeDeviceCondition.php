<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\DeviceCondition;

class SaveRearrangeDeviceCondition
{
    public static function execute(Request $request): array
    {
        try {
            $sl = 1;
            foreach ($request->id as $id) {
                DeviceCondition::where('id', $id)->update([
                    'serial' => $sl
                ]);
                $sl++;
            }

            return [
                'status' => 'success',
                'message' => 'Device Conditions are Rerranged'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
