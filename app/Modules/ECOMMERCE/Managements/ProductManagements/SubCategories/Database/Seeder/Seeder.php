<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;

class Seeder extends SeederClass
{
    public function run(): void
    {
        DB::transaction(function () {
            $now = Carbon::now();

            // Ensure subcategories from Categories seeder exist (idempotent)
            $mapping = [
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
            ];

            foreach ($mapping as $catSlug => $subs) {
                $category = Category::where('slug', $catSlug)->first();
                if (!$category) continue;
                foreach ($subs as $s) {
                    Subcategory::updateOrCreate(
                        ['slug' => $s['slug']],
                        ['category_id' => $category->id, 'name' => $s['name'], 'status' => 1, 'featured' => 0, 'updated_at' => $now, 'created_at' => $now]
                    );
                }
            }
        });
    }
}
