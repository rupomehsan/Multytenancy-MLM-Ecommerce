<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Database\Models\SideBanner;

class DeleteSideBanner
{
    public static function execute($slug)
    {
        $data = SideBanner::where('slug', $slug)->first();
        if ($data && $data->banner_img) {
            if (file_exists(public_path($data->banner_img))) {
                unlink(public_path($data->banner_img));
            }
        }
        $data->delete();
        return ['status' => 'success', 'message' => 'Data deleted successfully.'];
    }
}
