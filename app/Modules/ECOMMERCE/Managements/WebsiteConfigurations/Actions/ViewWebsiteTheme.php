<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;

class ViewWebsiteTheme
{
    public static function execute(Request $request)
    {
        $data = GeneralInfo::first() ?? new GeneralInfo();
        return ['data' => $data];
    }
}
