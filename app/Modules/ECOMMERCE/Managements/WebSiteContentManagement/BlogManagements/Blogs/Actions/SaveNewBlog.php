<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Actions;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Database\Models\Blog;

class SaveNewBlog
{
    public static function execute(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => 'required',
            'image' => 'required',
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $get_image = $request->file('image');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/blogImages/';
            $location = public_path($relativeDir);

            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }

            $get_image->move($location, $image_name);
            $image = $relativeDir . $image_name;
        }

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->title));
        $slug = preg_replace('!\s+!', '-', $clean);

        Blog::insert([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'image' => $image,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'tags' => $request->tags,
            'slug' => $slug . time(),
            'status' => 1,
            'created_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'New Blog Has Published'
        ];
    }
}
