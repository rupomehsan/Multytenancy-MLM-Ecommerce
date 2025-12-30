<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\PromotionalBanner;

class RemovePromotionalBackgroundImage
{
    public static function execute(Request $request)
    {
        $data = PromotionalBanner::where('id', 1)->first();
        if ($data && $data->background_image != '' && file_exists(public_path($data->background_image))) {
            unlink(public_path($data->background_image));
        }
        $data->background_image = null;
        $data->save();
        return ['status' => 'success', 'message' => 'Background image removed successfully'];
    }
}
