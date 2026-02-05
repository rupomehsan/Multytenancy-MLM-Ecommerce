<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Database\Models\VideoGallery;

class GetVideoGalleryForEdit
{
    public static function execute($slug)
    {
        $data = VideoGallery::where('slug', $slug)->first();
        return ['data' => $data];
    }
}
