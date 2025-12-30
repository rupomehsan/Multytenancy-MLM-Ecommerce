<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\Banner;

class UpdateBanner
{
    public static function execute(Request $request)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $data = Banner::where('slug', $request->slug)->first();

        $image = $data->image;
        if ($request->hasFile('image')) {
            if ($data->image != '' && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }
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

        $data->image = $image;
        $data->status = $request->status;
        $data->link = $request->link;
        $data->position = $request->position;
        $data->sub_title = $request->sub_title;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->btn_text = $request->btn_text;
        $data->btn_link = $request->btn_link;
        $data->text_position = $request->text_position;
        $data->updated_at = Carbon::now();
        $data->save();

        return ['status' => 'success', 'message' => 'Data has been Updated'];
    }
}
