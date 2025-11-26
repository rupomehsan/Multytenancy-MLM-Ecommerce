<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;
use Carbon\Carbon;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
    php artisan db:seed --class="\App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder\Seeder"
     */
    static $model = \App\Modules\ECOMMERCE\Managements\Configurations\Models\ConfigSetup::class;

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
