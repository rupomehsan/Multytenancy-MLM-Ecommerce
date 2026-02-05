<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Database\Models\VideoGallery;

class DeleteVideoGallery
{
    public static function execute($slug)
    {
        $data = VideoGallery::where('slug', $slug)->first();
        $data->delete();
        return ['status' => 'success', 'message' => 'Deleted successfully!', 'data' => 1];
    }
}
