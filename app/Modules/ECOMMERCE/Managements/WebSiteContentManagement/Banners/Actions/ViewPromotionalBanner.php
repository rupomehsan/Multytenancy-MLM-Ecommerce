<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\PromotionalBanner;

class ViewPromotionalBanner
{
    public static function execute(Request $request)
    {
        $promotionalBanner = PromotionalBanner::where('id', 1)->first();
        return ['promotionalBanner' => $promotionalBanner];
    }
}
