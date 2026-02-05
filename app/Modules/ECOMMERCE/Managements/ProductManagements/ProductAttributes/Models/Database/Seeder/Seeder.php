<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Models\Database\Models\ProductModel;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds for Product Models.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $now = Carbon::now();

            // Get brands
            $samsung = Brand::where('slug', 'samsung')->first();
            $apple = Brand::where('slug', 'apple')->first();
            $nike = Brand::where('slug', 'nike')->first();

            $models = [];

            if ($samsung) {
                $models = array_merge($models, [
                    ['brand_id' => $samsung->id, 'name' => 'Galaxy S23', 'code' => 'S23', 'slug' => 'galaxy-s23'],
                    ['brand_id' => $samsung->id, 'name' => 'Galaxy A54', 'code' => 'A54', 'slug' => 'galaxy-a54'],
                    ['brand_id' => $samsung->id, 'name' => 'Galaxy Z Fold 5', 'code' => 'ZF5', 'slug' => 'galaxy-z-fold-5'],
                ]);
            }

            if ($apple) {
                $models = array_merge($models, [
                    ['brand_id' => $apple->id, 'name' => 'iPhone 15 Pro', 'code' => 'IP15P', 'slug' => 'iphone-15-pro'],
                    ['brand_id' => $apple->id, 'name' => 'iPhone 15', 'code' => 'IP15', 'slug' => 'iphone-15'],
                    ['brand_id' => $apple->id, 'name' => 'iPhone 14', 'code' => 'IP14', 'slug' => 'iphone-14'],
                ]);
            }

            if ($nike) {
                $models = array_merge($models, [
                    ['brand_id' => $nike->id, 'name' => 'Air Max 270', 'code' => 'AM270', 'slug' => 'air-max-270'],
                    ['brand_id' => $nike->id, 'name' => 'Air Force 1', 'code' => 'AF1', 'slug' => 'air-force-1'],
                ]);
            }

            foreach ($models as $data) {
                ProductModel::updateOrCreate(
                    ['slug' => $data['slug']],
                    array_merge($data, ['status' => 1, 'updated_at' => $now, 'created_at' => $now])
                );
            }
        });
    }
}
