<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\Banner;

class SaveNewBanner
{
    public static function execute(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'status' => 'required',
            'position' => 'required',
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $get_image = $request->file('image');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/banners/';
            $location = public_path($relativeDir);
            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }
            \Intervention\Image\Facades\Image::make($get_image)->save($location . $image_name, 60);
            $image = $relativeDir . $image_name;
        }

        $banners = Banner::where('type', 2)->count();

        Banner::create([
            'sub_title' => $request->sub_title,
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'btn_text' => $request->btn_text,
            'btn_link' => $request->btn_link,
            'text_position' => $request->text_position,
            'position' => $request->position,
            'image' => $image,
            'type' => 2,
            'serial' => $banners + 1,
            'slug' => str::random(5) . time(),
            'status' => $request->status,
            'created_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Banner has been Added'];
    }
}
