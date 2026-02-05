<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Banners\Database\Models\PromotionalBanner;

class UpdatePromotionalBanner
{
    public static function execute(Request $request)
    {
        $started_at = str_replace("/", "-", $request->started_at);
        $started_at = date("Y-m-d H:i:s", strtotime($started_at));

        $end_at = str_replace("/", "-", $request->end_at);
        $end_at = date("Y-m-d H:i:s", strtotime($end_at));

        $data = PromotionalBanner::firstOrNew(['id' => 1]);

        $icon = request()->icon ?? ($data->icon ?? "");
        if ($request->hasFile('icon')) {
            if ($icon != '' && file_exists(public_path($icon))) {
                unlink(public_path($icon));
            }
            $get_image = $request->file('icon');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/promotional/';
            $location = public_path($relativeDir);
            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }
            if (strtolower($get_image->getClientOriginalExtension()) == 'svg') {
                $get_image->move($location, $image_name);
            } else {
                \Intervention\Image\Facades\Image::make($get_image)->save($location . $image_name, 60);
            }
            $icon = $relativeDir . $image_name;
        }

        $product_image = request()->product_image ?? ($data->product_image ?? "");
        if ($request->hasFile('product_image')) {
            if ($product_image != '' && file_exists(public_path($product_image))) {
                unlink(public_path($product_image));
            }
            $get_image = $request->file('product_image');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/promotional/';
            $location = public_path($relativeDir);
            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }
            if (strtolower($get_image->getClientOriginalExtension()) == 'svg') {
                $get_image->move($location, $image_name);
            } else {
                \Intervention\Image\Facades\Image::make($get_image)->save($location . $image_name, 60);
            }
            $product_image = $relativeDir . $image_name;
        }

        $background_image = request()->background_image ?? ($data->background_image ?? "");
        if ($request->hasFile('background_image')) {
            if ($background_image != '' && file_exists(public_path($background_image))) {
                unlink(public_path($background_image));
            }
            $get_image = $request->file('background_image');
            $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/promotional/';
            $location = public_path($relativeDir);
            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }
            if (strtolower($get_image->getClientOriginalExtension()) == 'svg') {
                $get_image->move($location, $image_name);
            } else {
                \Intervention\Image\Facades\Image::make($get_image)->save($location . $image_name, 60);
            }
            $background_image = $relativeDir . $image_name;
        }

        $data->icon = $icon;
        $data->product_image = $product_image;
        $data->background_image = $background_image;
        $data->started_at = $started_at;
        $data->end_at = $end_at;
        $data->heading = $request->heading;
        $data->heading_color = $request->heading_color;
        $data->title = $request->title;
        $data->title_color = $request->title_color;
        $data->description = $request->description;
        $data->description_color = $request->description_color;
        $data->url = $request->url;
        $data->btn_text = $request->btn_text;
        $data->btn_text_color = $request->btn_text_color;
        $data->btn_bg_color = $request->btn_bg_color;
        $data->background_color = $request->background_color;
        $data->video_url = $request->video_url;
        $data->time_bg_color = $request->time_bg_color;
        $data->time_font_color = $request->time_font_color;
        $data->updated_at = Carbon::now();
        $data->save();

        return ['status' => 'success', 'message' => 'Promotional banner Updated Successfully'];
    }
}
