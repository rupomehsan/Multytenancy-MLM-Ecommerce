<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductImage;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductVariant;

class CreateProduct
{
    public static function execute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $image = null;
        if ($request->hasFile('image')) {
            $get_image = $request->file('image');
            $image_name = Str::random(5) . time() . '.' . $get_image->getClientOriginalExtension();
            $location = self::ensureUploadDirExists('uploads/productImages');

            if ($get_image->getClientOriginalExtension() == 'svg') {
                $get_image->move($location, $image_name);
            } else {
                Image::make($get_image)->save($location . $image_name, 60);
            }

            $image = "uploads/productImages/" . $image_name;
        }

        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->name));
        $slug = preg_replace('!\s+!', '-', $clean);

        $product = new Product();
        $product->name = $request->name;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->tags = $request->tags;
        $product->video_url = $request->video_url;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->childcategory_id = $request->childcategory_id;
        $product->image = $image;
        $product->flag_id = $request->flag_id;
        $product->slug = $slug . "-" . time() . Str::random(5);
        $product->status = 1;
        $product->unit_id = isset($request->unit_id) ? $request->unit_id : null;
        $product->specification = $request->specification;
        $product->warrenty_policy = $request->warrenty_policy;
        $product->size_chart = $request->size_chart;
        $product->chest = $request->chest;
        $product->length = $request->length;
        $product->sleeve = $request->sleeve;
        $product->waist = $request->waist;
        $product->weight = $request->weight;
        $product->size_ratio = $request->size_ratio;
        $product->fabrication = $request->fabrication;
        $product->fabrication_gsm_ounce = $request->fabrication_gsm_ounce;
        $product->contact_number = $request->contact_number;
        $product->low_stock = $request->low_stock;
        $product->is_product_qty_multiply = $request->is_product_qty_multiply ?? 0;
        $product->brand_id = $request->brand_id;
        $product->model_id = $request->model_id;
        $product->code = $request->code;
        $product->meta_title = $request->meta_title;
        $product->meta_keywords = $request->meta_keywords;
        $product->meta_description = $request->meta_description;
        $product->created_at = Carbon::now();

        if ($request->has_variant == 1) {
            $product->price = $request->price > 0 ? $request->price : 0;
            $product->discount_price = $request->discount_price > 0 ? $request->discount_price : 0;
            $product->stock = 0;
            $product->multiple_images = NULL;
            $product->warrenty_id = NULL;
            $product->has_variant = 1;

            $product->save();

            $i = 0;
            foreach ($request->product_variant_price as $price_id) {
                $name = NULL;
                if (isset($request->file('product_variant_image')[$i]) && $request->file('product_variant_image')[$i]) {
                    $variant_image = $request->file('product_variant_image')[$i];
                    $variant_image_name = Str::random(5) . time() . $i . '.' . $variant_image->getClientOriginalExtension();
                    $variant_location = self::ensureUploadDirExists('uploads/productImages');

                    if ($variant_image->getClientOriginalExtension() == 'svg') {
                        $variant_image->move($variant_location, $variant_image_name);
                    } else {
                        Image::make($variant_image)->save($variant_location . $variant_image_name, 60);
                    }
                    $name = "uploads/productImages/" . $variant_image_name;
                }

                if ($i == 0) {
                    $product->price = $request->product_variant_price[$i];
                    $product->discount_price = $request->product_variant_discounted_price[$i];
                    $product->warrenty_id = isset($request->product_variant_warrenty_id[$i]) ? $request->product_variant_warrenty_id[$i] : null;
                    $product->save();
                }

                ProductVariant::insert([
                    'product_id' => $product->id,
                    'color_id' => isset($request->product_variant_color_id[$i]) ? $request->product_variant_color_id[$i] : null,
                    'size_id' => isset($request->product_variant_size_id[$i]) ? $request->product_variant_size_id[$i] : null,
                    'region_id' => isset($request->product_variant_region_id[$i]) ? $request->product_variant_region_id[$i] : null,
                    'sim_id' => isset($request->product_variant_sim_id[$i]) ? $request->product_variant_sim_id[$i] : null,
                    'storage_type_id' => isset($request->product_variant_storage_type_id[$i]) ? $request->product_variant_storage_type_id[$i] : null,
                    'device_condition_id' => isset($request->product_variant_device_condition_id[$i]) ? $request->product_variant_device_condition_id[$i] : null,
                    'warrenty_id' => isset($request->product_variant_warrenty_id[$i]) ? $request->product_variant_warrenty_id[$i] : null,
                    'price' => $request->product_variant_price[$i],
                    'discounted_price' => $request->product_variant_discounted_price[$i],
                    'stock' => isset($request->product_variant_stock[$i]) ? $request->product_variant_stock[$i] : 0,
                    'image' => $name,
                    'created_at' => Carbon::now()
                ]);
                $i++;
            }
        } else {
            $product->price = $request->price > 0 ? $request->price : 0;
            $product->discount_price = $request->discount_price > 0 ? $request->discount_price : 0;
            $product->stock = $request->stock > 0 ? $request->stock : 0;
            $product->warrenty_id = $request->warrenty_id;
            $product->has_variant = 0;

            $files = [];
            if ($request->hasfile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $photo_name = Str::random(5) . time() . '.' . $file->getClientOriginalExtension();
                    $photo_location = self::ensureUploadDirExists('uploads/productImages');

                    if ($file->getClientOriginalExtension() == 'svg') {
                        $file->move($photo_location, $photo_name);
                    } else {
                        Image::make($file)->save($photo_location . $photo_name, 60);
                    }
                    $files[] = "uploads/productImages/" . $photo_name;
                }
                $product->multiple_images = json_encode($files);
            }

            $product->save();

            if (count($files) > 0) {
                foreach ($files as $file) {
                    ProductImage::insert([
                        'product_id' => $product->id,
                        'image' => $file,
                        'created_at' => Carbon::now()
                    ]);
                }
            }
        }

        return [
            'status' => 'success',
            'message' => 'Product is Inserted'
        ];
    }

    private static function ensureUploadDirExists($relativePath = 'uploads/productImages')
    {
        $location = public_path(rtrim($relativePath, '/') . '/');
        if (!file_exists($location)) {
            @mkdir($location, 0755, true);
            @chmod($location, 0755);
        }
        return $location;
    }
}
