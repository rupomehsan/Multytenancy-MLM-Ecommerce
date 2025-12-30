<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;

class ViewSeoHomePage
{
    public static function execute(Request $request)
    {
        $data = GeneralInfo::select('meta_title', 'meta_keywords', 'meta_description', 'meta_og_title', 'meta_og_description', 'meta_og_image')->first() ?? new GeneralInfo();
        return ['data' => $data];
    }
}
