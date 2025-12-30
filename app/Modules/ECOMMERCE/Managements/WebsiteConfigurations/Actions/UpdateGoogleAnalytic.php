<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;
use Carbon\Carbon;

class UpdateGoogleAnalytic
{
    public static function execute(Request $request)
    {
        GeneralInfo::where('id', 1)->update([
            'google_analytic_status' => $request->google_analytic_status,
            'google_analytic_tracking_id' => $request->google_analytic_tracking_id,
            'updated_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Google Analytic Info Updated'];
    }
}
