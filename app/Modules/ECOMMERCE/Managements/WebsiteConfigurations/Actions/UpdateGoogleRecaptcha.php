<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GoogleRecaptcha;
use Carbon\Carbon;

class UpdateGoogleRecaptcha
{
    public static function execute(Request $request)
    {
        GoogleRecaptcha::where('id', 1)->update([
            'captcha_site_key' => $request->captcha_site_key,
            'captcha_secret_key' => $request->captcha_secret_key,
            'status' => $request->status,
            'updated_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Google Recaptcha Info Updated'];
    }
}
