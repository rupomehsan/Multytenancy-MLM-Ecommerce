<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\DeviceCondition;

class ViewRearrangeDeviceCondition
{
    public static function execute(Request $request): array
    {
        try {
            $conditions = DeviceCondition::orderBy('serial', 'asc')->get();

            return [
                'status' => 'success',
                'conditions' => $conditions,
                'view' => 'rearrangeDeviceCondition'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
