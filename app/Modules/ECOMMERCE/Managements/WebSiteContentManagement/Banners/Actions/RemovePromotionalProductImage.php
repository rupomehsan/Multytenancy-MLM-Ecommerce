<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\PromotionalBanner;

class RemovePromotionalProductImage
{
    public static function execute(Request $request)
    {
        $data = PromotionalBanner::where('id', 1)->first();
        if ($data && $data->product_image != '' && file_exists(public_path($data->product_image))) {
            unlink(public_path($data->product_image));
        }
        $data->product_image = null;
        $data->save();
        return ['status' => 'success', 'message' => 'Product image removed successfully'];
    }
}
