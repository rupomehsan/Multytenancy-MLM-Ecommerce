<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\Banner;

class UpdateRearrangedBanners
{
    public static function execute(Request $request)
    {
        $sl = 1;
        foreach ($request->slug as $slug) {
            Banner::where('slug', $slug)->update([
                'serial' => $sl
            ]);
            $sl++;
        }
        return ['status' => 'success', 'message' => 'Banner has been Rerranged'];
    }
}
