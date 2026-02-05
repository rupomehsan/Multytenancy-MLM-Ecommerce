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

class UpdateProduct
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

        $product = Product::where('id', $request->id)->first();

        $image = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image != '' && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

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

        $product->name = $request->name;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->tags = $request->tags;
        $product->video_url = $request->video_url;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->childcategory_id = $request->childcategory_id;
        $product->image = $image;
        $product->specification = $request->specification;
        $product->warrenty_policy = $request->warrenty_policy;
        $product->size_chart = $request->size_chart ?? $product->size_chart;
        $product->chest = $request->chest ?? $product->chest;
        $product->length = $request->length ?? $product->length;
        $product->sleeve = $request->sleeve ?? $product->sleeve;
        $product->waist = $request->waist ?? $product->waist;
        $product->weight = $request->weight ?? $product->weight;
        $product->size_ratio = $request->size_ratio ?? $product->size_ratio;
        $product->fabrication = $request->fabrication ?? $product->fabrication;
        $product->fabrication_gsm_ounce = $request->fabrication_gsm_ounce ?? $product->fabrication_gsm_ounce;
        $product->contact_number = $request->contact_number ?? $product->contact_number;
        $product->low_stock = $request->low_stock;
        $product->is_product_qty_multiply = $request->is_product_qty_multiply;
        $product->brand_id = $request->brand_id;
        $product->model_id = $request->model_id;
        $product->code = $request->code;
        $product->unit_id = isset($request->unit_id) ? $request->unit_id : null;
        $product->status = $request->status;
        $product->flag_id = $request->flag_id;
        $product->meta_title = $request->meta_title;
        $product->meta_keywords = $request->meta_keywords;
        $product->meta_description = $request->meta_description;
        $product->updated_at = Carbon::now();

        if ($request->has_variant == 1) {
            $gallery = ProductImage::where('product_id', $request->id)->get();
            if (count($gallery) > 0) {
                foreach ($gallery as $img) {
                    if ($img->image && file_exists(public_path($img->image))) {
                        unlink(public_path($img->image));
                    }
                    $img->delete();
                }
            }

            $product->price = $request->price > 0 ? $request->price : 0;
            $product->discount_price = $request->discount_price > 0 ? $request->discount_price : 0;
            
            $product->multiple_images = NULL;
            $product->warrenty_id = NULL;
            $product->has_variant = 1;

            $i = 0;
            foreach ($request->product_variant_price as $price_id) {
                if ($i == 0) {
                    $product->price = $request->product_variant_price[$i];
                    $product->discount_price = $request->product_variant_discounted_price[$i];
                    $product->warrenty_id = isset($request->product_variant_warrenty_id[$i]) ? $request->product_variant_warrenty_id[$i] : null;
                }

                $product_variant_id = isset($request->product_variant_id[$i]) ? $request->product_variant_id[$i] : null;

                if ($product_variant_id) {
                    $variantInfo = ProductVariant::where('id', $product_variant_id)->first();
                    $name = $variantInfo->image;

                    if (isset($request->file('product_variant_image')[$i]) && $request->file('product_variant_image')[$i]) {
                        if ($variantInfo->image && file_exists(public_path($variantInfo->image))) {
                            unlink(public_path($variantInfo->image));
                        }

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

                    $variantInfo->color_id = isset($request->product_variant_color_id[$i]) && $request->product_variant_color_id[$i] !== '' ? $request->product_variant_color_id[$i] : null;
                    $variantInfo->size_id = isset($request->product_variant_size_id[$i]) && $request->product_variant_size_id[$i] !== '' ? $request->product_variant_size_id[$i] : null;
                    $variantInfo->region_id = isset($request->product_variant_region_id[$i]) && $request->product_variant_region_id[$i] !== '' ? $request->product_variant_region_id[$i] : null;
                    $variantInfo->sim_id = isset($request->product_variant_sim_id[$i]) && $request->product_variant_sim_id[$i] !== '' ? $request->product_variant_sim_id[$i] : null;
                    $variantInfo->storage_type_id = isset($request->product_variant_storage_type_id[$i]) && $request->product_variant_storage_type_id[$i] !== '' ? $request->product_variant_storage_type_id[$i] : null;
                    $variantInfo->device_condition_id = isset($request->product_variant_device_condition_id[$i]) && $request->product_variant_device_condition_id[$i] !== '' ? $request->product_variant_device_condition_id[$i] : null;
                    $variantInfo->warrenty_id = isset($request->product_variant_warrenty_id[$i]) && $request->product_variant_warrenty_id[$i] !== '' ? $request->product_variant_warrenty_id[$i] : null;
                    $variantInfo->price = $request->product_variant_price[$i];
                    $variantInfo->discounted_price = $request->product_variant_discounted_price[$i];
                    $variantInfo->stock = isset($request->product_variant_stock[$i]) ? $request->product_variant_stock[$i] : 0;
                    $variantInfo->image = $name;
                    $variantInfo->updated_at = Carbon::now();
                    $variantInfo->save();
                } else {
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

                    ProductVariant::insert([
                        'product_id' => $product->id,
                        'color_id' => isset($request->product_variant_color_id[$i]) && $request->product_variant_color_id[$i] !== '' ? $request->product_variant_color_id[$i] : null,
                        'size_id' => isset($request->product_variant_size_id[$i]) && $request->product_variant_size_id[$i] !== '' ? $request->product_variant_size_id[$i] : null,
                        'region_id' => isset($request->product_variant_region_id[$i]) && $request->product_variant_region_id[$i] !== '' ? $request->product_variant_region_id[$i] : null,
                        'sim_id' => isset($request->product_variant_sim_id[$i]) && $request->product_variant_sim_id[$i] !== '' ? $request->product_variant_sim_id[$i] : null,
                        'storage_type_id' => isset($request->product_variant_storage_type_id[$i]) && $request->product_variant_storage_type_id[$i] !== '' ? $request->product_variant_storage_type_id[$i] : null,
                        'device_condition_id' => isset($request->product_variant_device_condition_id[$i]) && $request->product_variant_device_condition_id[$i] !== '' ? $request->product_variant_device_condition_id[$i] : null,
                        'warrenty_id' => isset($request->product_variant_warrenty_id[$i]) && $request->product_variant_warrenty_id[$i] !== '' ? $request->product_variant_warrenty_id[$i] : null,
                        'price' => $request->product_variant_price[$i],
                        'discounted_price' => $request->product_variant_discounted_price[$i],
                        'stock' => isset($request->product_variant_stock[$i]) ? $request->product_variant_stock[$i] : 0,
                        'image' => $name,
                        'created_at' => Carbon::now()
                    ]);
                }
                $i++;
            }
            
            // Recalculate total stock from all variants AFTER they are saved
            $totalStock = ProductVariant::where('product_id', $product->id)->sum('stock');
            $product->stock = $totalStock;
            $product->save();
        } else {
            $product->price = $request->price > 0 ? $request->price : 0;
            $product->discount_price = $request->discount_price > 0 ? $request->discount_price : 0;
            $product->stock = $request->stock > 0 ? $request->stock : 0;
            $product->warrenty_id = $request->warrenty_id;
            $product->has_variant = 0;

            $variants = ProductVariant::where('product_id', $request->id)->orderBy('id', 'asc')->get();
            if (count($variants) > 0) {
                foreach ($variants as $img) {
                    if ($img->image && file_exists(public_path($img->image))) {
                        unlink(public_path($img->image));
                    }
                    $img->delete();
                }
            }

            $files = [];
            if (isset($request->old) && is_array($request->old) && count($request->old) > 0) {
                $oldImageIdArray = array();
                foreach ($request->old as $oldImage) {
                    array_push($oldImageIdArray, $oldImage);
                }

                $gallery = ProductImage::where('product_id', $product->id)->get();
                foreach ($gallery as $multipleImage) {
                    if (!in_array($multipleImage->id, $oldImageIdArray)) {
                        if ($multipleImage->image && file_exists(public_path($multipleImage->image))) {
                            unlink(public_path($multipleImage->image));
                        }
                        $multipleImage->delete();
                    } else {
                        $files[] = $multipleImage->image;
                    }
                }
            } else {
                ProductImage::where('product_id', $product->id)->delete();
            }

            if ($request->hasfile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $photo_name = Str::random(5) . time() . '.' . $file->getClientOriginalExtension();
                    $photo_location = self::ensureUploadDirExists('uploads/productImages');

                    if ($file->getClientOriginalExtension() == 'svg') {
                        $file->move($photo_location, $photo_name);
                    } else {
                        Image::make($file)->save($photo_location . $photo_name, 60);
                    }

                    $photo_path = "uploads/productImages/" . $photo_name;
                    $files[] = $photo_path;

                    ProductImage::insert([
                        'product_id' => $product->id,
                        'image' => $photo_path,
                        'created_at' => Carbon::now()
                    ]);
                }
            }

            $product->multiple_images = json_encode($files);
            $product->save();
        }

        return [
            'status' => 'success',
            'message' => 'Product Updated'
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
