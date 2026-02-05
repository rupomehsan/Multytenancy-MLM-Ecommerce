<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds for Brands.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $now = Carbon::now();

            $brands = [
                ['name' => 'Samsung', 'slug' => 'samsung', 'serial' => 1, 'featured' => 1],
                ['name' => 'Apple', 'slug' => 'apple', 'serial' => 2, 'featured' => 1],
                ['name' => 'Sony', 'slug' => 'sony', 'serial' => 3, 'featured' => 1],
                ['name' => 'LG', 'slug' => 'lg', 'serial' => 4, 'featured' => 0],
                ['name' => 'Nike', 'slug' => 'nike', 'serial' => 5, 'featured' => 1],
                ['name' => 'Adidas', 'slug' => 'adidas', 'serial' => 6, 'featured' => 1],
                ['name' => 'Puma', 'slug' => 'puma', 'serial' => 7, 'featured' => 0],
                ['name' => 'Dell', 'slug' => 'dell', 'serial' => 8, 'featured' => 0],
                ['name' => 'HP', 'slug' => 'hp', 'serial' => 9, 'featured' => 0],
                ['name' => 'Lenovo', 'slug' => 'lenovo', 'serial' => 10, 'featured' => 0],
            ];

            foreach ($brands as $data) {
                Brand::updateOrCreate(
                    ['slug' => $data['slug']],
                    array_merge($data, ['status' => 1, 'logo' => null, 'banner' => null, 'categories' => null, 'subcategories' => null, 'childcategories' => null, 'updated_at' => $now, 'created_at' => $now])
                );
            }
        });
    }
}
