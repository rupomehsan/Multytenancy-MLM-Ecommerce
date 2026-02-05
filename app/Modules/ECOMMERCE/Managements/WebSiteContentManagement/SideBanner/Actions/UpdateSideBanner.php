<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Sohibd\Laravelslug\Generate;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Database\Models\SideBanner;

class UpdateSideBanner
{
    public static function execute(Request $request)
    {
        $data = SideBanner::where('id', $request->custom_id)->first();

        $request->validate([
            'banner_img' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner_link' => 'required|url',
            'status' => 'nullable|in:active,inactive',
            'title' => 'nullable|string|max:255',
            'button_title' => 'nullable|string|max:255',
            'button_url' => 'nullable|url',
        ]);

        $image = $data->banner_img;
        if ($request->hasFile('banner_img')) {
            if ($image != '' && file_exists(public_path($image))) {
                unlink(public_path($image));
            }

            $get_image = $request->file('banner_img');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/banner_img/';
            $location = public_path($relativeDir);
            if (!file_exists($location)) {
                mkdir($location, 0755, true);
            }
            $get_image->move($location, $image_name);
            $image = $relativeDir . $image_name;
        }

        $slug = Generate::Slug($request->banner_link);
        if (empty($slug)) {
            $slug = Str::slug($request->title ?? Str::random(6));
        }
        $sameSlugCount = SideBanner::where('slug', $slug)->where('id', '!=', $request->custom_id)->count();
        if ($sameSlugCount > 0) {
            $slug .= "-" . ($sameSlugCount + 1);
        }

        SideBanner::where('id', $request->custom_id)->update([
            'banner_img' => $image,
            'banner_link' => $request->banner_link,
            'title' => $request->title,
            'button_title' => $request->button_title,
            'button_url' => $request->button_url,
            'creator' => auth()->user()->id,
            'slug' => $slug,
            'status' => $request->status,
            'created_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Side Banner has been Updated'];
    }
}
