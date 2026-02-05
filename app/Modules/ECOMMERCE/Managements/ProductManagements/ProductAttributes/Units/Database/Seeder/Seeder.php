<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Models\Unit;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds for Units.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $now = Carbon::now();

            $units = [
                ['name' => 'Piece'],
                ['name' => 'Kilogram'],
                ['name' => 'Gram'],
                ['name' => 'Liter'],
                ['name' => 'Milliliter'],
                ['name' => 'Meter'],
                ['name' => 'Centimeter'],
                ['name' => 'Box'],
                ['name' => 'Pack'],
                ['name' => 'Dozen'],
                ['name' => 'Pair'],
                ['name' => 'Set'],
            ];

            foreach ($units as $data) {
                Unit::updateOrCreate(
                    ['name' => $data['name']],
                    array_merge($data, ['status' => 1, 'updated_at' => $now, 'created_at' => $now])
                );
            }
        });
    }
}
