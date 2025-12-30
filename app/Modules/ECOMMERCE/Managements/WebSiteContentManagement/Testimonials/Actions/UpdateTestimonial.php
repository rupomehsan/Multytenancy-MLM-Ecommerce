<?php

namespace App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Actions;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Modules\ECOMMERCE\Managements\WebSiteContentManagement\Testimonials\Database\Models\Testimonial;

class UpdateTestimonial
{
    public static function execute(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'rating' => 'required',
            'description' => 'required'
        ]);

        $data = Testimonial::where('slug', $request->slug)->first();

        $image = $data->customer_image;
        if ($request->hasFile('image')) {
            if ($data->customer_image != '' && file_exists(public_path($data->customer_image))) {
                unlink(public_path($data->customer_image));
            }

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

        $data->customer_image = $image;
        $data->description = $request->description;
        $data->rating = $request->rating;
        $data->customer_name = $request->name;
        $data->designation = $request->designation;
        $data->updated_at = Carbon::now();
        $data->save();

        return ['status' => 'success', 'message' => 'Testimonial Updated'];
    }
}
