<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Actions;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\BlogManagements\Blogs\Database\Models\Blog;

class UpdateBlog
{
    public static function execute(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => 'required',
            'status' => 'required',
        ]);

        $blog = Blog::where('id', $request->blog_id)->first();
        $originalTitle = $blog->title;

        $image = $blog->image;
        if ($request->hasFile('image')) {
            if ($blog->image != '' && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }

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

        $blog->category_id = $request->category_id;
        $blog->title = $request->title;
        $blog->image = $image;
        $blog->short_description = $request->short_description;
        $blog->description = $request->description;
        $blog->tags = $request->tags;

        if ($originalTitle != $request->title) {
            $blog->slug = $slug . time();
        }

        $blog->status = $request->status;
        $blog->updated_at = Carbon::now();
        $blog->save();

        return [
            'status' => 'success',
            'message' => 'Blog Has been Updated',
            'data' => $blog
        ];
    }
}
