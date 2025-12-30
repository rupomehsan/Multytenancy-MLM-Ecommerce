<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\Banner;

class SaveNewSlider
{
    public static function execute(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $get_image = $request->file('image');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/sliders/';
            $location = public_path($relativeDir);
            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }
            \Intervention\Image\Facades\Image::make($get_image)->save($location . $image_name, 60);
            $image = $relativeDir . $image_name;
        }

        $sliders = Banner::where('type', 1)->count();

        Banner::insert([
            'sub_title' => $request->sub_title,
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'btn_text' => $request->btn_text,
            'btn_link' => $request->btn_link,
            'text_position' => $request->text_position,
            'image' => $image,
            'type' => 1,
            'serial' => $sliders + 1,
            'slug' => str::random(5) . time(),
            'status' => 1,
            'created_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Slider has been Added'];
    }
}
