<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\StorageType;

class ViewRearrangeStorage
{
    public static function execute(Request $request): array
    {
        try {
            $storages = StorageType::where('status', 1)->orderBy('serial', 'asc')->get();

            return [
                'status' => 'success',
                'storages' => $storages,
                'view' => 'backend.config.rearrangeStorage'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
