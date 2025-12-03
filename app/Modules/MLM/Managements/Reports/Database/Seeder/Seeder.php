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
    static $model = \App\Modules\{path}\Models\Model::class;

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
