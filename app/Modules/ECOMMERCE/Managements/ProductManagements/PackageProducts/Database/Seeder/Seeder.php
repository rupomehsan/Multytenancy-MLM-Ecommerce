<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\PackageProducts\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;
use App\Modules\ECOMMERCE\Managements\ProductManagements\PackageProducts\Database\Models\PackageProductItem;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Models\Unit;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Models\Flag;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds for Package Products.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $now = Carbon::now();

            // Get references
            $electronicsCat = Category::where('slug', 'electronics')->first();
            $fashionCat = Category::where('slug', 'fashion')->first();
            $piece = Unit::where('name', 'Piece')->first();
            $hotDealFlag = Flag::where('slug', 'hot-deal')->first();
            
            // Get products for packages
            $galaxyS23 = Product::where('slug', 'samsung-galaxy-s23')->first();
            $earbuds = Product::where('slug', 'wireless-earbuds')->first();
            $nikeShoes = Product::where('slug', 'nike-air-max-270')->first();
            $tshirt = Product::where('slug', 'adidas-mens-tshirt')->first();
            
            $black = Color::where('name', 'Black')->first();
            $white = Color::where('name', 'White')->first();
            $sizeM = ProductSize::where('slug', 'm')->first();
            $size9 = ProductSize::where('slug', 'size-9')->first();

            // Package 1: Smartphone Combo (Phone + Earbuds)
            if ($electronicsCat && $galaxyS23 && $earbuds && $piece) {
                $package1 = Product::updateOrCreate(
                    ['slug' => 'smartphone-combo-package'],
                    [
                        'category_id' => $electronicsCat->id,
                        'name' => 'Smartphone Combo Package',
                        'product_type' => 'Package',
                        'code' => 'PKG-COMBO-001',
                        'short_description' => 'Complete smartphone package with wireless earbuds',
                        'description' => '<p>Perfect combo package including Samsung Galaxy S23 and premium wireless earbuds at a special discounted price.</p>',
                        'price' => 84998,
                        'discount_price' => 76999,
                        'stock' => 25,
                        'unit_id' => $piece->id,
                        'low_stock' => 5,
                        'reward_points' => 800,
                        'tags' => 'package,combo,smartphone,earbuds',
                        'flag_id' => $hotDealFlag ? $hotDealFlag->id : null,
                        'status' => 1,
                        'has_variant' => 0,
                        'is_demo' => 0,
                        'is_package' => 1,
                        'avg_cost_price' => 67500,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                // Package items
                PackageProductItem::updateOrCreate(
                    ['package_product_id' => $package1->id, 'product_id' => $galaxyS23->id],
                    [
                        'color_id' => $black ? $black->id : null,
                        'size_id' => null,
                        'quantity' => 1,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                PackageProductItem::updateOrCreate(
                    ['package_product_id' => $package1->id, 'product_id' => $earbuds->id],
                    [
                        'color_id' => null,
                        'size_id' => null,
                        'quantity' => 1,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }

            // Package 2: Fitness Starter Pack (Shoes + T-shirt)
            if ($fashionCat && $nikeShoes && $tshirt && $piece) {
                $package2 = Product::updateOrCreate(
                    ['slug' => 'fitness-starter-pack'],
                    [
                        'category_id' => $fashionCat->id,
                        'name' => 'Fitness Starter Pack',
                        'product_type' => 'Package',
                        'code' => 'PKG-FIT-001',
                        'short_description' => 'Complete fitness package with shoes and apparel',
                        'description' => '<p>Get started with your fitness journey! This package includes Nike Air Max 270 running shoes and Adidas cotton t-shirt.</p>',
                        'price' => 14998,
                        'discount_price' => 11999,
                        'stock' => 40,
                        'unit_id' => $piece->id,
                        'low_stock' => 10,
                        'reward_points' => 120,
                        'tags' => 'package,fitness,sports,combo',
                        'flag_id' => $hotDealFlag ? $hotDealFlag->id : null,
                        'status' => 1,
                        'has_variant' => 0,
                        'is_demo' => 0,
                        'is_package' => 1,
                        'avg_cost_price' => 9000,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                // Package items
                PackageProductItem::updateOrCreate(
                    ['package_product_id' => $package2->id, 'product_id' => $nikeShoes->id],
                    [
                        'color_id' => $black ? $black->id : null,
                        'size_id' => $size9 ? $size9->id : null,
                        'quantity' => 1,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                PackageProductItem::updateOrCreate(
                    ['package_product_id' => $package2->id, 'product_id' => $tshirt->id],
                    [
                        'color_id' => $white ? $white->id : null,
                        'size_id' => $sizeM ? $sizeM->id : null,
                        'quantity' => 2,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        });
    }
}
