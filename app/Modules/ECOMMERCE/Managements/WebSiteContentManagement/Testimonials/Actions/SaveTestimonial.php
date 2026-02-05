<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Database\Models\Testimonial;

class SaveTestimonial
{
    public static function execute(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'rating' => 'required',
            'description' => 'required'
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $get_image = $request->file('image');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $relativeDir = 'uploads/testimonial/';
            $location = public_path($relativeDir);

            if (!\Illuminate\Support\Facades\File::exists($location)) {
                \Illuminate\Support\Facades\File::makeDirectory($location, 0755, true);
            }

            $get_image->move($location, $image_name);
            $image = $relativeDir . $image_name;
        }

        Testimonial::insert([
            'description' => $request->description,
            'rating' => $request->rating,
            'customer_name' => $request->name,
            'designation' => $request->designation,
            'customer_image' => $image,
            'slug' => Str::random(5) . time(),
            'created_at' => Carbon::now(),
        ]);

        return ['status' => 'success', 'message' => 'Testimonial Saved'];
    }
}
