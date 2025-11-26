<?php

namespace App\Modules\Managements\MLM\Settings\Database\Seeders;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
    php artisan db:seed --class="\App\Modules\Managements\MLM\Settings\Database\Seeders\Seeder"
     */
    static $model = \App\Modules\Managements\MLM\Settings\Models\Model::class;

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
