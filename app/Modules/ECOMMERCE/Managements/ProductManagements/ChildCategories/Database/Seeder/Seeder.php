<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Models\ChildCategory;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds for Child Categories.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $now = Carbon::now();

            $mapping = [
                'electronics/mobile-phones' => [
                    ['name' => 'Smartphones', 'slug' => 'smartphones'],
                    ['name' => 'Feature Phones', 'slug' => 'feature-phones'],
                ],
                'fashion/shoes' => [
                    ['name' => 'Men Shoes', 'slug' => 'men-shoes'],
                    ['name' => 'Women Shoes', 'slug' => 'women-shoes'],
                ],
            ];

            foreach ($mapping as $key => $list) {
                [$catSlug, $subSlug] = explode('/', $key);
                $category = Category::where('slug', $catSlug)->first();
                $sub = Subcategory::where('slug', $subSlug)->first();
                if (!$category || !$sub) continue;
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
