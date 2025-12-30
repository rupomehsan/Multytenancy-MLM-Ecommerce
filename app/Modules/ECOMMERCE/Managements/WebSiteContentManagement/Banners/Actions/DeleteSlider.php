<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\Banner;

class DeleteSlider
{
    public static function execute($slug)
    {
        $data = Banner::where('slug', $slug)->first();
        if ($data->image) {
            if (file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }
        }
        $data->delete();
        return ['status' => 'success', 'message' => 'Data deleted successfully.'];
    }
}
