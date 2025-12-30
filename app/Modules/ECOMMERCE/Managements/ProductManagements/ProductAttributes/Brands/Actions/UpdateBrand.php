<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Sohibd\Laravelslug\Generate;
use Intervention\Image\Facades\Image;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;

class UpdateBrand
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

            $duplicateBrandExists = Brand::where('name', $request->name)
                ->where('id', '!=', $request->id)
                ->first();

            if ($duplicateBrandExists) {
                return [
                    'status' => 'error',
                    'message' => 'Duplicate Brand Exists'
                ];
            }

            $data = Brand::where('id', $request->id)->first();

            if (!$data) {
                return [
                    'status' => 'error',
                    'message' => 'Brand not found.'
                ];
            }

            $logo = $data->logo;
            if ($request->hasFile('logo')) {
                if ($logo != '' && file_exists(public_path($logo))) {
                    unlink(public_path($logo));
                }

                $get_image = $request->file('logo');
                $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
                $location = public_path('brand_images/');

                if ($get_image->getClientOriginalExtension() == 'svg') {
                    $get_image->move($location, $image_name);
                } else {
                    Image::make($get_image)->save($location . $image_name, 25);
                }

                $logo = "brand_images/" . $image_name;
            }

            $banner = $data->banner;
            if ($request->hasFile('banner')) {
                if ($banner != '' && file_exists(public_path($banner))) {
                    unlink(public_path($banner));
                }

                $get_image = $request->file('banner');
                $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
                $location = public_path('uploads/brand_images/');

                if (!file_exists($location)) {
                    mkdir($location, 0777, true);
                }

                $get_image->move($location, $image_name);
                $banner = "uploads/brand_images/" . $image_name;
            }

            Brand::where('id', $request->id)->update([
                'name' => $request->name,
                'logo' => $logo,
                'banner' => $banner,
                'categories' => $request->categories ? implode(",", $request->categories) : null,
                'subcategories' => $request->subcategories ? implode(",", $request->subcategories) : null,
                'childcategories' => $request->childcategories ? implode(",", $request->childcategories) : null,
                'slug' => Generate::Slug($request->name),
                'status' => $request->status,
                'featured' => $request->featured,
                'updated_at' => Carbon::now()
            ]);

            return [
                'status' => 'success',
                'message' => 'Brand Info Updated'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
