<?php

namespace App\Modules\{path}\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
    php artisan db:seed --class="\App\Modules\{path}\Database\Seeders\Seeder"
     */
    public function run(): void
    {
        DB::transaction(function () {
            $now = Carbon::now();

            // Create child categories for specific subcategories
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

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();


        self::$model::create([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
