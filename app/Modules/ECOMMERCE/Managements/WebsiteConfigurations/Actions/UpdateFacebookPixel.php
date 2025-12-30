<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;
use Carbon\Carbon;

class UpdateFacebookPixel
{
    public static function execute(Request $request)
    {
        GeneralInfo::where('id', 1)->update([
            'fb_pixel_status' => $request->fb_pixel_status,
            'fb_pixel_app_id' => $request->fb_pixel_app_id,
            'updated_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Facebook Pixel Info Updated'];
    }
}
