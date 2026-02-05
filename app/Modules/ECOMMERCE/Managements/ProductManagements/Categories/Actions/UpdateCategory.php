<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Sohibd\Laravelslug\Generate;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

class UpdateCategory
{
    public static function execute(Request $request): array
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'errors' => $validator->errors()
                ];
            }

            $duplicateCategoryExists = Category::where('id', '!=', $request->id)
                ->where('name', $request->name)
                ->first();
            $duplicateCategorySlugExists = Category::where('id', '!=', $request->id)
                ->where('slug', $request->slug)
                ->first();

            if ($duplicateCategoryExists || $duplicateCategorySlugExists) {
                return [
                    'status' => 'error',
                    'message' => 'Duplicate Category Or Slug Exists'
                ];
            }

            $data = Category::where('id', $request->id)->first();

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Category not found.'
                ];
            }

            $uploadsDir = public_path('uploads/');
            if (!file_exists($uploadsDir)) {
                mkdir($uploadsDir, 0777, true);
            }
            $categoryImagesDir = public_path('uploads/category_images/');
            if (!file_exists($categoryImagesDir)) {
                mkdir($categoryImagesDir, 0777, true);
            }

            $icon = $data->icon;
            if ($request->hasFile('icon')) {
                if ($icon != '' && file_exists(public_path($icon))) {
                    unlink(public_path($icon));
                }

                $get_image = $request->file('icon');
                $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
                $location = public_path('uploads/category_images/');
                $get_image->move($location, $image_name);
                $icon = "uploads/category_images/" . $image_name;
            }

            $categoryBanner = $data->banner_image;
            if ($request->hasFile('banner_image')) {
                if ($categoryBanner != '' && file_exists(public_path($categoryBanner))) {
                    unlink(public_path($categoryBanner));
                }

                $get_image = $request->file('banner_image');
                $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
                $location = public_path('uploads/category_images/');
                $get_image->move($location, $image_name);
                $categoryBanner = "uploads/category_images/" . $image_name;
            }

            Category::where('id', $request->id)->update([
                'name' => $request->name,
                'icon' => $icon,
                'banner_image' => $categoryBanner,
                'slug' => Generate::Slug($request->slug),
                'status' => $request->status,
                'featured' => $request->featured ? $request->featured : 0,
                'show_on_navbar' => $request->show_on_navbar,
                'updated_at' => Carbon::now()
            ]);

            return [
                'status' => 'success',
                'message' => 'Category has been Updated'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
