<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Models\ChildCategory;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds for Categories, Subcategories and ChildCategories
     */
    public function run(): void
    {
        DB::transaction(function () {
            $now = Carbon::now();

            // Main categories (realistic, market-standard)
            $categories = [
                ['name' => 'Electronics', 'slug' => 'electronics', 'icon' => 'fa-tv', 'banner_image' => null, 'serial' => 1],
                ['name' => 'Fashion', 'slug' => 'fashion', 'icon' => 'fa-tshirt', 'banner_image' => null, 'serial' => 2],
                ['name' => 'Home & Living', 'slug' => 'home-living', 'icon' => 'fa-home', 'banner_image' => null, 'serial' => 3],
                ['name' => 'Beauty & Health', 'slug' => 'beauty-health', 'icon' => 'fa-heart', 'banner_image' => null, 'serial' => 4],
                ['name' => 'Sports & Outdoors', 'slug' => 'sports-outdoors', 'icon' => 'fa-football-ball', 'banner_image' => null, 'serial' => 5],
                ['name' => 'Automotive', 'slug' => 'automotive', 'icon' => 'fa-car', 'banner_image' => null, 'serial' => 6],
            ];

            $createdCategories = [];
            foreach ($categories as $data) {
                $cat = Category::updateOrCreate(
                    ['slug' => $data['slug']],
                    array_merge($data, ['status' => 1, 'featured' => 0, 'show_on_navbar' => 1, 'updated_at' => $now, 'created_at' => $now])
                );
                $createdCategories[$cat->slug] = $cat;
            }

            // Subcategories mapped to main categories
            $subcategories = [
                'electronics' => [
                    ['name' => 'Mobile Phones', 'slug' => 'mobile-phones'],
                    ['name' => 'Computers & Laptops', 'slug' => 'computers-laptops'],
                    ['name' => 'TV & Home Theater', 'slug' => 'tv-home-theater'],
                ],
                'fashion' => [
                    ['name' => 'Men Clothing', 'slug' => 'men-clothing'],
                    ['name' => 'Women Clothing', 'slug' => 'women-clothing'],
                    ['name' => 'Shoes', 'slug' => 'shoes'],
                ],
                'home-living' => [
                    ['name' => 'Kitchen & Dining', 'slug' => 'kitchen-dining'],
                    ['name' => 'Furniture', 'slug' => 'furniture'],
                ],
            ];

            $createdSubcategories = [];
            foreach ($subcategories as $catSlug => $list) {
                if (!isset($createdCategories[$catSlug])) continue;
                foreach ($list as $sc) {
                    $sub = Subcategory::updateOrCreate(
                        ['slug' => $sc['slug']],
                        ['category_id' => $createdCategories[$catSlug]->id, 'name' => $sc['name'], 'icon' => null, 'image' => null, 'status' => 1, 'featured' => 0, 'updated_at' => $now, 'created_at' => $now]
                    );
                    $createdSubcategories[$catSlug . '/' . $sub->slug] = $sub;
                }
            }

            // Child categories (3rd level)
            $childs = [
                'electronics/mobile-phones' => [
                    ['name' => 'Smartphones', 'slug' => 'smartphones'],
                    ['name' => 'Feature Phones', 'slug' => 'feature-phones'],
                ],
                'fashion/shoes' => [
                    ['name' => 'Men Shoes', 'slug' => 'men-shoes'],
                    ['name' => 'Women Shoes', 'slug' => 'women-shoes'],
                ],
            ];

            foreach ($childs as $key => $list) {
                if (!isset($createdSubcategories[$key])) continue;
                $sub = $createdSubcategories[$key];
                $category = Category::find($sub->category_id);
                foreach ($list as $cc) {
                    ChildCategory::updateOrCreate(
                        ['slug' => $cc['slug']],
                        ['category_id' => $category->id, 'subcategory_id' => $sub->id, 'name' => $cc['name'], 'status' => 1, 'updated_at' => $now, 'created_at' => $now]
                    );
                }
            }
        });
    }
}
