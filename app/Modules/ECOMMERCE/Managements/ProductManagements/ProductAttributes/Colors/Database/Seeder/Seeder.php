<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds for Colors.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $now = Carbon::now();

            $colors = [
                ['name' => 'Red', 'code' => '#FF0000'],
                ['name' => 'Blue', 'code' => '#0000FF'],
                ['name' => 'Green', 'code' => '#00FF00'],
                ['name' => 'Black', 'code' => '#000000'],
                ['name' => 'White', 'code' => '#FFFFFF'],
                ['name' => 'Yellow', 'code' => '#FFFF00'],
                ['name' => 'Orange', 'code' => '#FFA500'],
                ['name' => 'Purple', 'code' => '#800080'],
                ['name' => 'Pink', 'code' => '#FFC0CB'],
                ['name' => 'Gray', 'code' => '#808080'],
                ['name' => 'Brown', 'code' => '#A52A2A'],
                ['name' => 'Navy Blue', 'code' => '#000080'],
                ['name' => 'Maroon', 'code' => '#800000'],
                ['name' => 'Gold', 'code' => '#FFD700'],
                ['name' => 'Silver', 'code' => '#C0C0C0'],
            ];

            foreach ($colors as $data) {
                Color::updateOrCreate(
                    ['code' => $data['code']],
                    array_merge($data, ['updated_at' => $now, 'created_at' => $now])
                );
            }
        });
    }
}
