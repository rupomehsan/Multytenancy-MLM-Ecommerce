<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\SocialLogin;
use Carbon\Carbon;

class UpdateSocialLogin
{
    public static function execute(Request $request)
    {
        SocialLogin::updateOrCreate(
            ['id' => 1],
            [
                'google_client_id' => $request->google_client_id,
                'google_client_secret' => $request->google_client_secret,
                'google_redirect_url' => $request->google_redirect_url,
                'facebook_client_id' => $request->facebook_client_id,
                'facebook_client_secret' => $request->facebook_client_secret,
                'facebook_redirect_url' => $request->facebook_redirect_url,
                'updated_at' => Carbon::now()
            ]
        );

        return ['status' => 'success', 'message' => 'Social Login Info Updated'];
    }
}
