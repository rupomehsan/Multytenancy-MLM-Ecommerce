<?php

namespace App\Modules\Managements\MLM\Commissions\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Modules\MLM\Managements\Commissions\Database\Models\CommissionSettingsModel;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
    php artisan db:seed --class="\App\Modules\Managements\MLM\Commissions\Database\Seeder\Seeder"
     */
     
    $model = CommissionSettingsModel::class;
    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();


        self::$model::create([
            'level_1_percentage' => 10.00,
            'level_2_percentage' => 5.00,
            'level_3_percentage' => 2.00,
            'minimum_withdrawal' => 100.00,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
