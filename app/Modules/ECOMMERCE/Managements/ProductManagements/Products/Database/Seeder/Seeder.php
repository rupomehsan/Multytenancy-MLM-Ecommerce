<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductVariant;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Models\ChildCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Database\Models\ProductModel;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Models\Unit;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Models\Flag;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds for Products.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $now = Carbon::now();

            // Get references
            $electronicsCat = Category::where('slug', 'electronics')->first();
            $fashionCat = Category::where('slug', 'fashion')->first();
            $mobilePhonesSub = Subcategory::where('slug', 'mobile-phones')->first();
            $shoesSub = Subcategory::where('slug', 'shoes')->first();
            $menClothingSub = Subcategory::where('slug', 'men-clothing')->first();
            $smartphonesChild = ChildCategory::where('slug', 'smartphones')->first();
            $menShoesChild = ChildCategory::where('slug', 'men-shoes')->first();
            
            $samsung = Brand::where('slug', 'samsung')->first();
            $apple = Brand::where('slug', 'apple')->first();
            $nike = Brand::where('slug', 'nike')->first();
            $adidas = Brand::where('slug', 'adidas')->first();
            
            $galaxyS23 = ProductModel::where('slug', 'galaxy-s23')->first();
            $iphone15Pro = ProductModel::where('slug', 'iphone-15-pro')->first();
            $airMax270 = ProductModel::where('slug', 'air-max-270')->first();
            
            $piece = Unit::where('name', 'Piece')->first();
            $pair = Unit::where('name', 'Pair')->first();
            
            $newArrivalFlag = Flag::where('slug', 'new-arrival')->first();
            $bestSellerFlag = Flag::where('slug', 'best-seller')->first();
            $hotDealFlag = Flag::where('slug', 'hot-deal')->first();
            
            $black = Color::where('name', 'Black')->first();
            $white = Color::where('name', 'White')->first();
            $blue = Color::where('name', 'Blue')->first();
            $red = Color::where('name', 'Red')->first();
            
            $sizeM = ProductSize::where('slug', 'm')->first();
            $sizeL = ProductSize::where('slug', 'l')->first();
            $sizeXL = ProductSize::where('slug', 'xl')->first();
            $size8 = ProductSize::where('slug', 'size-8')->first();
            $size9 = ProductSize::where('slug', 'size-9')->first();
            $size10 = ProductSize::where('slug', 'size-10')->first();

            // Product 1: Samsung Galaxy S23 (with variants)
            if ($electronicsCat && $mobilePhonesSub && $samsung && $galaxyS23 && $piece) {
                $product1 = Product::updateOrCreate(
                    ['slug' => 'samsung-galaxy-s23'],
                    [
                        'category_id' => $electronicsCat->id,
                        'subcategory_id' => $mobilePhonesSub->id,
                        'childcategory_id' => $smartphonesChild ? $smartphonesChild->id : null,
                        'brand_id' => $samsung->id,
                        'model_id' => $galaxyS23->id,
                        'name' => 'Samsung Galaxy S23 5G',
                        'product_type' => 'Electronics',
                        'code' => 'SAM-S23-001',
                        'short_description' => 'Latest Samsung flagship with powerful camera',
                        'description' => '<p>Samsung Galaxy S23 features a stunning 6.1-inch display, Snapdragon 8 Gen 2 processor, and a triple camera system with 50MP main sensor.</p>',
                        'specification' => '<ul><li>Display: 6.1" FHD+ AMOLED</li><li>Processor: Snapdragon 8 Gen 2</li><li>RAM: 8GB</li><li>Storage: 256GB</li></ul>',
                        'price' => 79999,
                        'discount_price' => 74999,
                        'stock' => 50,
                        'unit_id' => $piece->id,
                        'low_stock' => 10,
                        'reward_points' => 750,
                        'tags' => 'smartphone,5g,samsung,flagship',
                        'flag_id' => $newArrivalFlag ? $newArrivalFlag->id : null,
                        'status' => 1,
                        'has_variant' => 1,
                        'is_demo' => 0,
                        'is_package' => 0,
                        'avg_cost_price' => 65000,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                // Variants for Samsung S23
                if ($black) {
                    ProductVariant::updateOrCreate(
                        ['product_id' => $product1->id, 'color_id' => $black->id, 'size_id' => null],
                        ['stock' => 20, 'price' => 79999, 'discounted_price' => 74999, 'created_at' => $now, 'updated_at' => $now]
                    );
                }
                if ($white) {
                    ProductVariant::updateOrCreate(
                        ['product_id' => $product1->id, 'color_id' => $white->id, 'size_id' => null],
                        ['stock' => 15, 'price' => 79999, 'discounted_price' => 74999, 'created_at' => $now, 'updated_at' => $now]
                    );
                }
                if ($blue) {
                    ProductVariant::updateOrCreate(
                        ['product_id' => $product1->id, 'color_id' => $blue->id, 'size_id' => null],
                        ['stock' => 15, 'price' => 79999, 'discounted_price' => 74999, 'created_at' => $now, 'updated_at' => $now]
                    );
                }
            }

            // Product 2: iPhone 15 Pro (with variants)
            if ($electronicsCat && $mobilePhonesSub && $apple && $iphone15Pro && $piece) {
                $product2 = Product::updateOrCreate(
                    ['slug' => 'iphone-15-pro'],
                    [
                        'category_id' => $electronicsCat->id,
                        'subcategory_id' => $mobilePhonesSub->id,
                        'childcategory_id' => $smartphonesChild ? $smartphonesChild->id : null,
                        'brand_id' => $apple->id,
                        'model_id' => $iphone15Pro->id,
                        'name' => 'Apple iPhone 15 Pro',
                        'product_type' => 'Electronics',
                        'code' => 'APL-IP15P-001',
                        'short_description' => 'iPhone 15 Pro with titanium design and A17 Pro chip',
                        'description' => '<p>The iPhone 15 Pro features a titanium design, A17 Pro chip, and an advanced 48MP camera system with improved Night mode.</p>',
                        'specification' => '<ul><li>Display: 6.1" Super Retina XDR</li><li>Chip: A17 Pro</li><li>Camera: 48MP Main</li><li>Storage: 256GB</li></ul>',
                        'price' => 134999,
                        'discount_price' => 129999,
                        'stock' => 30,
                        'unit_id' => $piece->id,
                        'low_stock' => 5,
                        'reward_points' => 1300,
                        'tags' => 'iphone,apple,pro,5g',
                        'flag_id' => $bestSellerFlag ? $bestSellerFlag->id : null,
                        'status' => 1,
                        'has_variant' => 1,
                        'is_demo' => 0,
                        'is_package' => 0,
                        'avg_cost_price' => 115000,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                // Variants for iPhone 15 Pro
                if ($black) {
                    ProductVariant::updateOrCreate(
                        ['product_id' => $product2->id, 'color_id' => $black->id, 'size_id' => null],
                        ['stock' => 12, 'price' => 134999, 'discounted_price' => 129999, 'created_at' => $now, 'updated_at' => $now]
                    );
                }
                if ($white) {
                    ProductVariant::updateOrCreate(
                        ['product_id' => $product2->id, 'color_id' => $white->id, 'size_id' => null],
                        ['stock' => 10, 'price' => 134999, 'discounted_price' => 129999, 'created_at' => $now, 'updated_at' => $now]
                    );
                }
                if ($blue) {
                    ProductVariant::updateOrCreate(
                        ['product_id' => $product2->id, 'color_id' => $blue->id, 'size_id' => null],
                        ['stock' => 8, 'price' => 134999, 'discounted_price' => 129999, 'created_at' => $now, 'updated_at' => $now]
                    );
                }
            }

            // Product 3: Nike Air Max 270 (with color and size variants)
            if ($fashionCat && $shoesSub && $nike && $airMax270 && $pair) {
                $product3 = Product::updateOrCreate(
                    ['slug' => 'nike-air-max-270'],
                    [
                        'category_id' => $fashionCat->id,
                        'subcategory_id' => $shoesSub->id,
                        'childcategory_id' => $menShoesChild ? $menShoesChild->id : null,
                        'brand_id' => $nike->id,
                        'model_id' => $airMax270->id,
                        'name' => 'Nike Air Max 270 Running Shoes',
                        'product_type' => 'Footwear',
                        'code' => 'NIKE-AM270-001',
                        'short_description' => 'Comfortable running shoes with Max Air cushioning',
                        'description' => '<p>Nike Air Max 270 delivers incredible comfort with its large Max Air unit in the heel and lightweight mesh upper.</p>',
                        'specification' => '<ul><li>Upper: Mesh</li><li>Cushioning: Max Air</li><li>Sole: Rubber</li></ul>',
                        'price' => 12999,
                        'discount_price' => 10999,
                        'stock' => 100,
                        'unit_id' => $pair->id,
                        'low_stock' => 20,
                        'reward_points' => 110,
                        'tags' => 'nike,shoes,running,sports',
                        'flag_id' => $hotDealFlag ? $hotDealFlag->id : null,
                        'status' => 1,
                        'has_variant' => 1,
                        'is_demo' => 0,
                        'is_package' => 0,
                        'avg_cost_price' => 8000,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                // Variants for Nike shoes (color + size combinations)
                $colors = [$black, $white, $red];
                $sizes = [$size8, $size9, $size10];
                
                foreach ($colors as $color) {
                    if (!$color) continue;
                    foreach ($sizes as $size) {
                        if (!$size) continue;
                        ProductVariant::updateOrCreate(
                            ['product_id' => $product3->id, 'color_id' => $color->id, 'size_id' => $size->id],
                            ['stock' => 10, 'price' => 12999, 'discounted_price' => 10999, 'created_at' => $now, 'updated_at' => $now]
                        );
                    }
                }
            }

            // Product 4: Adidas Men's T-Shirt (simple product with color and size variants)
            if ($fashionCat && $menClothingSub && $adidas && $piece) {
                $product4 = Product::updateOrCreate(
                    ['slug' => 'adidas-mens-tshirt'],
                    [
                        'category_id' => $fashionCat->id,
                        'subcategory_id' => $menClothingSub->id,
                        'brand_id' => $adidas->id,
                        'name' => 'Adidas Men\'s Cotton T-Shirt',
                        'product_type' => 'Clothing',
                        'code' => 'ADIDAS-TSH-001',
                        'short_description' => 'Comfortable cotton t-shirt for everyday wear',
                        'description' => '<p>High-quality cotton t-shirt with Adidas branding, perfect for casual wear and sports activities.</p>',
                        'specification' => '<ul><li>Material: 100% Cotton</li><li>Fit: Regular</li><li>Care: Machine wash</li></ul>',
                        'price' => 1999,
                        'discount_price' => 1599,
                        'stock' => 200,
                        'unit_id' => $piece->id,
                        'low_stock' => 30,
                        'reward_points' => 16,
                        'tags' => 'adidas,tshirt,clothing,men',
                        'status' => 1,
                        'has_variant' => 1,
                        'is_demo' => 0,
                        'is_package' => 0,
                        'avg_cost_price' => 1000,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                // Variants for T-shirt
                $tshirtColors = [$black, $white, $blue, $red];
                $tshirtSizes = [$sizeM, $sizeL, $sizeXL];
                
                foreach ($tshirtColors as $color) {
                    if (!$color) continue;
                    foreach ($tshirtSizes as $size) {
                        if (!$size) continue;
                        ProductVariant::updateOrCreate(
                            ['product_id' => $product4->id, 'color_id' => $color->id, 'size_id' => $size->id],
                            ['stock' => 15, 'price' => 1999, 'discounted_price' => 1599, 'created_at' => $now, 'updated_at' => $now]
                        );
                    }
                }
            }

            // Product 5: Simple product without variants
            if ($electronicsCat && $piece) {
                Product::updateOrCreate(
                    ['slug' => 'wireless-earbuds'],
                    [
                        'category_id' => $electronicsCat->id,
                        'name' => 'Wireless Bluetooth Earbuds',
                        'product_type' => 'Electronics',
                        'code' => 'WL-EAR-001',
                        'short_description' => 'True wireless earbuds with noise cancellation',
                        'description' => '<p>Premium wireless earbuds with active noise cancellation, long battery life, and crystal clear sound quality.</p>',
                        'specification' => '<ul><li>Battery: 24 hours total</li><li>Connectivity: Bluetooth 5.2</li><li>Features: ANC, IPX4</li></ul>',
                        'price' => 4999,
                        'discount_price' => 3999,
                        'stock' => 75,
                        'unit_id' => $piece->id,
                        'low_stock' => 15,
                        'reward_points' => 40,
                        'tags' => 'earbuds,wireless,bluetooth,audio',
                        'status' => 1,
                        'has_variant' => 0,
                        'is_demo' => 0,
                        'is_package' => 0,
                        'avg_cost_price' => 2500,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        });
    }
}
