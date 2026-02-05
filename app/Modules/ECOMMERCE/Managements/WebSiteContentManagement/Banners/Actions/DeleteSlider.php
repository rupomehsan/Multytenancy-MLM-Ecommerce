<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\Banner;
use Illuminate\Support\Facades\File;

class DeleteSlider
{
    public static function execute($slug)
    {
        $slider = Banner::where('slug', $slug)->where('type', 1)->first();
        
        if (!$slider) {
            return ['status' => 'error', 'message' => 'Slider not found'];
        }

        // Delete the image file if it exists
        if ($slider->image && File::exists(public_path($slider->image))) {
            File::delete(public_path($slider->image));
        }

        $slider->delete();

        return ['status' => 'success', 'message' => 'Slider has been Deleted'];
    }
}
