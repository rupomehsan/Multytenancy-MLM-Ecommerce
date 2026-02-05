<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Sohibd\Laravelslug\Generate;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\CustomPages\Database\Models\CustomPage;

class UpdateCustomPage
{
    public static function execute(Request $request)
    {
        $data = CustomPage::where('id', $request->custom_page_id)->first();

        $image = $data->image;
        if ($request->hasFile('image')) {
            if ($image != '' && file_exists(public_path($image))) {
                unlink(public_path($image));
            }

            $get_image = $request->file('image');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/custom_pages/';
            $location = public_path($relativeDir);

            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }

            $get_image->move($location, $image_name);
            $image = $relativeDir . $image_name;
        }

        $slug = Generate::Slug($request->page_title);
        $sameSlugCount = CustomPage::where('slug', $slug)->where('id', '!=', $request->custom_page_id)->count();
        if ($sameSlugCount > 0) {
            $slug .= "-" . $sameSlugCount + 1;
        }

        CustomPage::where('id', $request->custom_page_id)->update([
            'image' => $image,
            'page_title' => $request->page_title,
            'description' => $request->description,
            'slug' => $slug,
            'status' => $request->status,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'created_at' => Carbon::now()
        ]);

        return ['status' => 'success', 'message' => 'Custom Page has been Updated'];
    }
}
