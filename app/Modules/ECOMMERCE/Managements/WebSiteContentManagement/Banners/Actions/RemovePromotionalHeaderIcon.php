<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\PromotionalBanner;

class RemovePromotionalHeaderIcon
{
    public static function execute(Request $request)
    {
        $data = PromotionalBanner::where('id', 1)->first();
        if ($data && $data->icon != '' && file_exists(public_path($data->icon))) {
            unlink(public_path($data->icon));
        }
        $data->icon = null;
        $data->save();
        return ['status' => 'success', 'message' => 'Icon removed successfully'];
    }
}
