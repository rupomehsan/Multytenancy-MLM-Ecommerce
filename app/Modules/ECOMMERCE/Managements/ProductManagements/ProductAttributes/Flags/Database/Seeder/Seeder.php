<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Models\Flag;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds for Flags.
     */
    public function run(): void
    {

        DB::transaction(function () {

            $now = Carbon::now();

            $flags = [
                ['name' => 'New Arrival', 'slug' => 'new-arrival', 'icon' => 'fa-star', 'featured' => 1],
                ['name' => 'Best Seller', 'slug' => 'best-seller', 'icon' => 'fa-fire', 'featured' => 1],
                ['name' => 'Hot Deal', 'slug' => 'hot-deal', 'icon' => 'fa-bolt', 'featured' => 1],
                ['name' => 'Sale', 'slug' => 'sale', 'icon' => 'fa-tag', 'featured' => 1],
                ['name' => 'Limited Edition', 'slug' => 'limited-edition', 'icon' => 'fa-crown', 'featured' => 0],
                ['name' => 'Featured', 'slug' => 'featured', 'icon' => 'fa-heart', 'featured' => 0],
                ['name' => 'Trending', 'slug' => 'trending', 'icon' => 'fa-chart-line', 'featured' => 0],
            ];

            foreach ($flags as $data) {
                Flag::updateOrCreate(
                    ['slug' => $data['slug']],
                    array_merge($data, ['status' => 1, 'updated_at' => $now, 'created_at' => $now])
                );
            }

        });

    }
}
