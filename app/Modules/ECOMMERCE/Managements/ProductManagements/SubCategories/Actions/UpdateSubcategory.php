<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Sohibd\Laravelslug\Generate;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;

class UpdateSubcategory
{
    public static function execute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'category_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $duplicateSubCategoryExists = Subcategory::where('id', '!=', $request->id)
            ->where('category_id', $request->category_id)
            ->where('name', $request->name)
            ->first();

        $duplicateSubCategorySlugExists = Subcategory::where('id', '!=', $request->id)
            ->where('category_id', $request->category_id)
            ->where('slug', $request->slug)
            ->first();

        if ($duplicateSubCategoryExists || $duplicateSubCategorySlugExists) {
            return [
                'status' => 'error',
                'message' => 'Duplicate Subcategory Exists'
            ];
        }

        $data = Subcategory::where('id', $request->id)->first();

        // Ensure uploads directory exists
        $uploadsDir = public_path('uploads/');
        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }
        $subcategoryImagesDir = public_path('uploads/subcategory_images/');
        if (!file_exists($subcategoryImagesDir)) {
            mkdir($subcategoryImagesDir, 0777, true);
        }

        $icon = $data->icon;
        if ($request->hasFile('icon')) {
            if ($icon != '' && file_exists(public_path($icon))) {
                unlink(public_path($icon));
            }

            $get_image = $request->file('icon');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('uploads/subcategory_images/');
            $get_image->move($location, $image_name);
            $icon = "uploads/subcategory_images/" . $image_name;
        }

        $image = $data->image;
        if ($request->hasFile('image')) {
            if ($image != '' && file_exists(public_path($image))) {
                unlink(public_path($image));
            }

            $get_image = $request->file('image');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = public_path('uploads/subcategory_images/');
            $get_image->move($location, $image_name);
            $image = "uploads/subcategory_images/" . $image_name;
        }

        Subcategory::where('id', $request->id)->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'icon' => $icon,
            'image' => $image,
            'slug' => Generate::Slug($request->name),
            'status' => $request->status,
            'featured' => $request->featured ?? 0,
            'updated_at' => Carbon::now()
        ]);

        return [
            'status' => 'success',
            'message' => 'Subcategory has been Updated'
        ];
    }
}
