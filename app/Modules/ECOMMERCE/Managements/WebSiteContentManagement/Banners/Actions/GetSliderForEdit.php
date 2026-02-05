<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\Banner;

class GetSliderForEdit
{
    public static function execute($slug)
    {
        $data = Banner::where('slug', $slug)->first();
        return ['data' => $data];
    }
}
