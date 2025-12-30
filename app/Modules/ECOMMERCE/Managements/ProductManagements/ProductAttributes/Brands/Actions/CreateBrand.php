<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Sohibd\Laravelslug\Generate;
use Intervention\Image\Facades\Image;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;

class CreateBrand
{
    public static function execute(Request $request): array
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255', 'unique:brands'],
            ]);

            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'errors' => $validator->errors()
                ];
            }

            $logo = null;
            if ($request->hasFile('logo')) {
                $get_image = $request->file('logo');
                $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
                $location = public_path('uploads/brand_images/');

                if (!file_exists($location)) {
                    mkdir($location, 0777, true);
                }

                if ($get_image->getClientOriginalExtension() == 'svg') {
                    $get_image->move($location, $image_name);
                } else {
                    Image::make($get_image)->save($location . $image_name, 25);
                }

                $logo = "uploads/brand_images/" . $image_name;
            }

            $banner = null;
            if ($request->hasFile('banner')) {
                $get_image = $request->file('banner');
                $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
                $location = public_path('uploads/brand_images/');

                if (!file_exists($location)) {
                    mkdir($location, 0777, true);
                }

                $get_image->move($location, $image_name);
                $banner = "uploads/brand_images/" . $image_name;
            }

            Brand::insert([
                'name' => $request->name,
                'logo' => $logo,
                'banner' => $banner,
                'categories' => $request->categories ? implode(",", $request->categories) : null,
                'subcategories' => $request->subcategories ? implode(",", $request->subcategories) : null,
                'childcategories' => $request->childcategories ? implode(",", $request->childcategories) : null,
                'slug' => Generate::Slug($request->name),
                'featured' => 0,
                'serial' => Brand::min('serial') - 1,
                'created_at' => Carbon::now()
            ]);

            return [
                'status' => 'success',
                'message' => 'Brand has been Added'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
