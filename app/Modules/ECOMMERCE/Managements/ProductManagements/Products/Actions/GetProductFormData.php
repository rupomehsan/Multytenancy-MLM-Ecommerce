<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Models\Flag;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductWarrenty;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Models\Unit;
use App\Models\Region;
use App\Models\Sim;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\DeviceCondition;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\StorageType;

class GetProductFormData
{
    public static function execute(Request $request)
    {
        $categories = Category::getDropDownList('name');
        $brands = Brand::getDropDownList('name');
        $flags = Flag::getDropDownList('name');
        $warrenties = ProductWarrenty::getDropDownList('name');
        $units = Unit::getDropDownList('name');
        $colors = Color::getDropDownList('name');
        $product_sizes = ProductSize::getDropDownList('name');
        $regions = Region::getDropDownList('name');
        $sim = Sim::getDropDownList('name');
        $storage_types = StorageType::getDropDownList('ram');
        $product_warrenties = ProductWarrenty::getDropDownList('name');
        $device_conditions = DeviceCondition::getDropDownList('name');

        return [
            'status' => 'success',
            'data' => compact(
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
