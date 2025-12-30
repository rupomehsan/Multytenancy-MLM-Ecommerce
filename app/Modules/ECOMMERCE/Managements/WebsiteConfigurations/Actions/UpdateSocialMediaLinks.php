<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;
use Carbon\Carbon;

class UpdateSocialMediaLinks
{
    public static function execute(Request $request)
    {
        GeneralInfo::where('id', 1)->update([
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'youtube' => $request->youtube,
            'messenger' => $request->messenger,
            'whatsapp' => $request->whatsapp,
            'telegram' => $request->telegram,
            'tiktok' => $request->tiktok,
            'pinterest' => $request->pinterest,
            'viber' => $request->viber,
            'updated_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Social Media Links Updated'];
    }
}
