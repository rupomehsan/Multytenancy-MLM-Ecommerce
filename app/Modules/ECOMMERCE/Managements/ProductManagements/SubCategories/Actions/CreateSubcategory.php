<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Sohibd\Laravelslug\Generate;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;

class CreateSubcategory
{
    public static function execute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        // Ensure uploads directory exists
        $uploadsDir = public_path('uploads/');
        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }
        $subcategoryImagesDir = public_path('uploads/subcategory_images/');
        if (!file_exists($subcategoryImagesDir)) {
            mkdir($subcategoryImagesDir, 0777, true);
        }

        $icon = null;
        if ($request->hasFile('icon')) {
            $get_image = $request->file('icon');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('uploads/subcategory_images/');
            $get_image->move($location, $image_name);
            $icon = "uploads/subcategory_images/" . $image_name;
        }

        $image = null;
        if ($request->hasFile('image')) {
            $get_image = $request->file('image');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('uploads/subcategory_images/');
            $get_image->move($location, $image_name);
            $image = "uploads/subcategory_images/" . $image_name;
        }

        Subcategory::insert([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'icon' => $icon,
            'image' => $image,
            'slug' => Generate::Slug($request->name),
            'status' => 1,
            'featured' => 0,
            'created_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Subcategory has been Added'
        ];
    }
}
