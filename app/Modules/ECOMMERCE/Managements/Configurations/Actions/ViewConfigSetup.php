<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\ConfigSetup;

class ViewConfigSetup
{
    public static function execute(Request $request): array
    {
        try {
            $techConfigs = ConfigSetup::orderBy('industry', 'desc')->get();
            $fashionConfigs = ConfigSetup::orderBy('industry', 'desc')->get();

            return [
                'status' => 'success',
                'techConfigs' => $techConfigs,
                'fashionConfigs' => $fashionConfigs
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
