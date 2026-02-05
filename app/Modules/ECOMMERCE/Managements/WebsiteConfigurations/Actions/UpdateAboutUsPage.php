<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\AboutUs;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UpdateAboutUsPage
{
    public static function execute(Request $request)
    {
        $data = AboutUs::first();
        $banner_bg = $data->banner_bg ?? '';
        if ($request->hasFile('banner_bg')) {
            if ($banner_bg != '' && file_exists(public_path($banner_bg))) {
                unlink(public_path($banner_bg));
            }
            $get_image = $request->file('banner_bg');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/about_us/';
            $location = public_path($relativeDir);
            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }
            $get_image->move($location, $image_name);
            $banner_bg = $relativeDir . $image_name;
        }

        $image = $data->image ?? '';
        if ($request->hasFile('image')) {
            if ($image != '' && file_exists(public_path($image))) {
                unlink(public_path($image));
            }
            $get_image = $request->file('image');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/about_us/';
            $location = public_path($relativeDir);
            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }
            $get_image->move($location, $image_name);
            $image = $relativeDir . $image_name;
        }

        if ($data) {
            $data->update([
                'banner_bg' => $banner_bg ? $banner_bg : $data->banner_bg,
                'image' => $image ? $image : $data->image,
                'section_sub_title' => $request->section_sub_title,
                'section_title' => $request->section_title,
                'section_description' => $request->section_description,
                'btn_icon_class' => $request->btn_icon_class,
                'btn_text' => $request->btn_text,
                'btn_link' => $request->btn_link,
                'updated_at' => Carbon::now(),
            ]);
        } else {
            AboutUs::create([
                'banner_bg' => $banner_bg ? $banner_bg : '',
                'image' => $image ? $image : '',
                'section_sub_title' => $request->section_sub_title,
                'section_title' => $request->section_title,
                'section_description' => $request->section_description,
                'btn_icon_class' => $request->btn_icon_class,
                'btn_text' => $request->btn_text,
                'btn_link' => $request->btn_link,
                'created_at' => Carbon::now(),
            ]);
        }

        return ['status' => 'success', 'message' => 'About Us Info Updated'];
    }
}
