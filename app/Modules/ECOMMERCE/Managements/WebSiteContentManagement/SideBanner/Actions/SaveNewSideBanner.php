<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Sohibd\Laravelslug\Generate;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\SideBanner\Database\Models\SideBanner;

class SaveNewSideBanner
{
    public static function execute(Request $request)
    {
        $request->validate([
            'banner_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner_link' => 'nullable|url',
            'title' => 'nullable|string|max:255',
            'button_title' => 'nullable|string|max:255',
            'button_url' => 'nullable|url',
        ]);

        $image = null;
        if ($request->hasFile('banner_img')) {
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
        $sameSlugCount = SideBanner::where('slug', $slug)->count();
        if ($sameSlugCount > 0) {
            $slug .= "-" . ($sameSlugCount + 1);
        }

        SideBanner::insert([
            'banner_img' => $image,
            'banner_link' => $request->banner_link,
            'title' => $request->title,
            'button_title' => $request->button_title,
            'button_url' => $request->button_url,
            'creator' => auth()->user()->id,
            'slug' => $slug,
            'status' => 'active',
            'created_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Side Banner has been Created'];
    }
}
