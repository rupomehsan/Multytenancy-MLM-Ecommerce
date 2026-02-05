<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\DeviceCondition;

class DeleteDeviceCondition
{
    public static function execute(Request $request, $id): array
    {
        try {
            DeviceCondition::where('id', $id)->delete();

            return [
                'status' => 'success',
                'message' => 'Deleted successfully.'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
