<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Videos\Database\Models\VideoGallery;

class UpdateVideoGallery
{
    public static function execute(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'source' => ['required'],
        ]);

        $data = VideoGallery::where('id', $request->video_gallery_id)->first();

        $data->title = $request->title ?? $data->title;
        $data->source = $request->source ?? $data->source;
        if ($data->title != $request->title) {
            $data->slug = Str::slug($request->title) . time();
        }

        $data->status = $request->status ?? $data->status;
        $data->updated_at = Carbon::now();
        $data->save();

        return ['status' => 'success', 'message' => 'Updated Successfully', 'data' => $data];
    }
}
