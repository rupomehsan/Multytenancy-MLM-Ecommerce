<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductWarrenty;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Models\Unit;
use App\Models\Region;
use App\Models\Sim;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\DeviceCondition;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\StorageType;

class GetVariantFormData
{
    public static function execute(Request $request)
    {
        $colors = Color::getDropDownList('name');
        $units = Unit::getDropDownList('name');
        $product_sizes = ProductSize::getDropDownList('name');
        $regions = Region::getDropDownList('name');
        $sim = Sim::getDropDownList('name');
        $storage_types = StorageType::getDropDownList('ram');
        $product_warrenties = ProductWarrenty::getDropDownList('name');
        $device_conditions = DeviceCondition::getDropDownList('name');

        return [
            'status' => 'success',
            'data' => compact(
                'colors',
                'units',
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
