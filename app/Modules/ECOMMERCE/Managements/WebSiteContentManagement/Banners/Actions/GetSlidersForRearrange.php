<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\Banner;

class GetSlidersForRearrange
{
    public static function execute(Request $request)
    {
        $data = Banner::where('type', 1)->orderBy('serial', 'asc')->get();
        return ['data' => $data];
    }
}
