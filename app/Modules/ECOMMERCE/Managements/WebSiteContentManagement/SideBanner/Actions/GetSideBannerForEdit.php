<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Database\Models\SideBanner;

class GetSideBannerForEdit
{
    public static function execute($slug)
    {
        $data = SideBanner::where('slug', $slug)->first();
        return ['data' => $data];
    }
}
