<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\ConfigSetup;

class UpdateConfigSetup
{
    public static function execute(Request $request): array
    {
        try {
            $configArray = [];

            if (isset($request->config_setup)) {
                foreach ($request->config_setup as $configSetup) {
                    $configArray[] = $configSetup;
                    ConfigSetup::where('code', $configSetup)->update([
                        'status' => 1,
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

            ConfigSetup::whereNotIn('code', $configArray)->update([
                'status' => 0,
                'updated_at' => Carbon::now()
            ]);

            return [
                'status' => 'success',
                'message' => 'Config Setup Updated'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
