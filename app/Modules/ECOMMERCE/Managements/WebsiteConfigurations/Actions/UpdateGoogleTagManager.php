<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;
use Carbon\Carbon;

class UpdateGoogleTagManager
{
    public static function execute(Request $request)
    {
        GeneralInfo::where('id', 1)->update([
            'google_tag_manager_status' => $request->google_tag_manager_status,
            'google_tag_manager_id' => $request->google_tag_manager_id,
            'updated_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Google Tag Manager Info Updated'];
    }
}
