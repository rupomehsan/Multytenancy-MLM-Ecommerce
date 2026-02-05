<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UpdateGeneralInfo
{
    public static function execute(Request $request)
    {
        $data = GeneralInfo::first() ?? new GeneralInfo();
        $image = $data->logo;
        if ($request->hasFile('logo')) {
            if ($data->logo != '' && file_exists(public_path($data->logo))) {
                unlink(public_path($data->logo));
            }
            $get_image = $request->file('logo');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/company_logo/';
            $location = public_path($relativeDir);
            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }
            $get_image->move($location, $image_name);
            $image = $relativeDir . $image_name;
        }

        $imageDark = $data->logo_dark;
        if ($request->hasFile('logo_dark')) {
            if ($data->logo_dark != '' && file_exists(public_path($data->logo_dark))) {
                unlink(public_path($data->logo_dark));
            }
            $get_image = $request->file('logo_dark');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/company_logo/';
            $location = public_path($relativeDir);
            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }
            $get_image->move($location, $image_name);
            $imageDark = $relativeDir . $image_name;
        }

        $favIcon = $data->fav_icon;
        if ($request->hasFile('fav_icon')) {
            if ($data->fav_icon != '' && file_exists(public_path($data->fav_icon))) {
                unlink(public_path($data->fav_icon));
            }
            $get_image = $request->file('fav_icon');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/company_logo/';
            $location = public_path($relativeDir);
            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }
            $get_image->move($location, $image_name);
            $favIcon = $relativeDir . $image_name;
        }

        $paymentBanner = $data->payment_banner;
        if ($request->hasFile('payment_banner')) {
            if ($data->payment_banner != '' && file_exists(public_path($data->payment_banner))) {
                unlink(public_path($data->payment_banner));
            }
            $get_image = $request->file('payment_banner');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/company_logo/';
            $location = public_path($relativeDir);
            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }
            if (strtolower($get_image->getClientOriginalExtension()) == 'svg') {
                $get_image->move($location, $image_name);
            } else {
                \Intervention\Image\Facades\Image::make($get_image)->save($location . $image_name, 25);
            }
            $paymentBanner = $relativeDir . $image_name;
        }

        // Handle admin login background image upload
        $adminLoginBgImage = $data->admin_login_bg_image;
        if ($request->hasFile('admin_login_bg_image')) {
            if ($data->admin_login_bg_image != '' && file_exists(public_path($data->admin_login_bg_image))) {
                unlink(public_path($data->admin_login_bg_image));
            }
            $get_image = $request->file('admin_login_bg_image');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/admin_login/';
            $location = public_path($relativeDir);
            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }
            $get_image->move($location, $image_name);
            $adminLoginBgImage = $relativeDir . $image_name;
        }

        GeneralInfo::updateOrCreate(
            ['id' => 1],
            [
                'logo' => $image,
                'logo_dark' => $imageDark,
                'fav_icon' => $favIcon,
                'tab_title' => $request->tab_title,
                'company_name' => $request->company_name,
                'short_description' => $request->short_description,
                'contact' => $request->contact,
                'email' => $request->email,
                'address' => $request->address,
                'google_map_link' => $request->google_map_link,
                'payment_banner' => $paymentBanner,
                'copyright_text' => $request->copyright_text,
                'admin_login_bg_image' => $adminLoginBgImage,
                'admin_login_bg_color' => $request->admin_login_bg_color ?? '#0b2a44',
                'updated_at' => Carbon::now()
            ]
        );

        return ['status' => 'success', 'message' => 'General Info Updated'];
    }
}
