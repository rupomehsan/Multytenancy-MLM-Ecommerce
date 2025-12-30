<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Database\Models\VideoGallery;

class SaveNewVideoGallery
{
    public static function execute(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'source' => ['required'],
        ]);

        VideoGallery::create([
            'title' => $request->title,
            'source' => $request->source,
            'creator' => auth()->user()->id,
            'slug' => Str::slug($request->title) . time(),
            'status' => 'active',
            'created_at' => Carbon::now(),
        ]);

        return ['status' => 'success', 'message' => 'Added successfully!'];
    }
}
