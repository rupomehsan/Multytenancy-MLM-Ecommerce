<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models\GeneralInfo;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UpdateSeoHomePage
{
    public static function execute(Request $request)
    {
        $data = GeneralInfo::first();
        $meta_og_image = $data->meta_og_image;
        if ($request->hasFile('meta_og_image')) {
            if ($data->meta_og_image != '' && file_exists(public_path($data->meta_og_image))) {
                unlink(public_path($data->meta_og_image));
            }
            $get_image = $request->file('meta_og_image');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/company_logo/';
            $location = public_path($relativeDir);
            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }
            $get_image->move($location, $image_name);
            $meta_og_image = $relativeDir . $image_name;
        }

        GeneralInfo::where('id', 1)->update([
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'meta_og_title' => $request->meta_og_title,
            'meta_og_description' => $request->meta_og_description,
            'meta_og_image' => $meta_og_image,
            'updated_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Homepage SEO Updated'];
    }
}
