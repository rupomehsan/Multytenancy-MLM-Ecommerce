<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductImage;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductVariant;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Models\ChildCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Models\Flag;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductWarrenty;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Models\Unit;
use App\Models\Region;
use App\Models\Sim;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\DeviceCondition;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\StorageType;

class GetProductForEdit
{
    public static function execute(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if (!$product) {
            return [
                'status' => 'error',
                'message' => 'Product not found'
            ];
        }

        $categories = Category::getDropDownList('name', $product->category_id);
        $brands = Brand::getDropDownList('name', $product->brand_id);
        $flags = Flag::getDropDownList('name', $product->flag_id);
        $warrenties = ProductWarrenty::getDropDownList('name', $product->warrenty_id);
        $units = Unit::getDropDownList('name', $product->unit_id);
        $colors = Color::getDropDownList('name');
        $product_sizes = ProductSize::getDropDownList('name');
        $regions = Region::getDropDownList('name');
        $sim = Sim::getDropDownList('name');
        $storage_types = StorageType::getDropDownList('ram');
        $product_warrenties = ProductWarrenty::getDropDownList('name');
        $device_conditions = DeviceCondition::getDropDownList('name');

        $subcategories = Subcategory::where('category_id', $product->category_id)
            ->select('name', 'id')
            ->orderBy('name', 'asc')
            ->get();

        $childcategories = ChildCategory::where('category_id', $product->category_id)
            ->where('subcategory_id', $product->subcategory_id)
            ->select('name', 'id')
            ->orderBy('name', 'asc')
            ->get();

        $productModels = Product::where('brand_id', $product->brand_id)
            ->select('name', 'id')
            ->orderBy('name', 'asc')
            ->get();

        $gallery = ProductImage::where('product_id', $product->id)->get();
        $productVariants = ProductVariant::where('product_id', $product->id)->orderBy('id', 'asc')->get();

        return [
            'status' => 'success',
            'data' => compact(
                'product',
                'gallery',
                'subcategories',
                'childcategories',
                'productModels',
                'productVariants',
                'categories',
                'brands',
                'flags',
                'warrenties',
                'units',
                'colors',
                'product_sizes',
                'regions',
                'sim',
                'storage_types',
                'product_warrenties',
                'device_conditions'
            )
        ];
    }
}
