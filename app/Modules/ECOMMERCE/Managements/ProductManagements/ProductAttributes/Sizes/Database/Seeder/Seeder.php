<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds for Product Sizes.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $now = Carbon::now();

            $sizes = [
                ['name' => 'XS', 'slug' => 'xs', 'serial' => 1],
                ['name' => 'S', 'slug' => 's', 'serial' => 2],
                ['name' => 'M', 'slug' => 'm', 'serial' => 3],
                ['name' => 'L', 'slug' => 'l', 'serial' => 4],
                ['name' => 'XL', 'slug' => 'xl', 'serial' => 5],
                ['name' => 'XXL', 'slug' => 'xxl', 'serial' => 6],
                ['name' => 'XXXL', 'slug' => 'xxxl', 'serial' => 7],
                ['name' => '6', 'slug' => 'size-6', 'serial' => 8],
                ['name' => '7', 'slug' => 'size-7', 'serial' => 9],
                ['name' => '8', 'slug' => 'size-8', 'serial' => 10],
                ['name' => '9', 'slug' => 'size-9', 'serial' => 11],
                ['name' => '10', 'slug' => 'size-10', 'serial' => 12],
            ];

            foreach ($sizes as $data) {
                ProductSize::updateOrCreate(
                    ['slug' => $data['slug']],
                    array_merge($data, ['status' => 1, 'updated_at' => $now, 'created_at' => $now])
                );
            }
        });
    }
}
