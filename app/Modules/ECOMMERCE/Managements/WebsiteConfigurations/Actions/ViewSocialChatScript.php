<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GoogleRecaptcha;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\SocialLogin;

class ViewSocialChatScript
{
    public static function execute(Request $request)
    {
        $googleRecaptcha = GoogleRecaptcha::first() ?? new GoogleRecaptcha();
        $generalInfo = GeneralInfo::first() ?? new GeneralInfo();
        $socialLoginInfo = SocialLogin::first() ?? new SocialLogin();

        return [
            'googleRecaptcha' => $googleRecaptcha,
            'generalInfo' => $generalInfo,
            'socialLoginInfo' => $socialLoginInfo
        ];
    }
}
