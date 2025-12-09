<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Actions;

use Illuminate\Support\Str;
use Sohibd\Laravelslug\Generate;
use Carbon\Carbon;



use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

class SaveNewCategory
{


    public static function execute($request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:categories'],
            ]);


            $uploadsDir = public_path('uploads/');
            if (!file_exists($uploadsDir)) {
                mkdir($uploadsDir, 0777, true);
            }
            $categoryImagesDir = public_path('uploads/category_images/');
            if (!file_exists($categoryImagesDir)) {
                mkdir($categoryImagesDir, 0777, true);
            }

            $icon = null;
            if ($request->hasFile('icon')) {
                $get_image = $request->file('icon');
                $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
                $location = public_path('uploads/category_images/');
                // Image::make($get_image)->save($location . $image_name, 80);
                $get_image->move($location, $image_name);
                $icon = "uploads/category_images/" . $image_name;
            }

            $categoryBanner = null;
            if ($request->hasFile('banner_image')) {
                $get_image = $request->file('banner_image');
                $image_name = str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
                $location = public_path('uploads/category_images/');
                // Image::make($get_image)->save($location . $image_name, 80);
                $get_image->move($location, $image_name);
                $categoryBanner = "uploads/category_images/" . $image_name;
            }

            Category::insert([
                'name' => $request->name,
                'featured' => $request->featured ? $request->featured : 0,
                'show_on_navbar' => $request->show_on_navbar ? $request->show_on_navbar : 1,
                'icon' => $icon,
                'banner_image' => $categoryBanner,
                'slug' => Generate::Slug($request->name),
                'status' => 1,
                'serial' => Category::min('serial') - 1,
                'created_at' => Carbon::now()
            ]);
            return ['success' => 'Category Added Successfully'];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
