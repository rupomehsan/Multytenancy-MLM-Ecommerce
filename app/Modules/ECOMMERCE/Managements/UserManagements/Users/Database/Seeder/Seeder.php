<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
    php artisan db:seed --class="\App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Seeder\Seeder"
     */
    static $model = '\App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User';

    public function run(): void
    {
        $faker = Faker::create();

        // Truncate users table to start fresh
        // DB::table('users')->truncate();

        $now = Carbon::now();

        // Insert three default users: Admin, Shop User, Customer
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('11111111'),
                'phone' => '01234567890',
                'address' => 'Admin Address',
                'user_type' => 1,
                'status' => 1,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Shop User',
                'email' => 'shop@gmail.com',
                'password' => Hash::make('11111111'),
                'phone' => '01987654321',
                'address' => 'Shop Address',
                'user_type' => 2,
                'status' => 1,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('11111111'),
                'phone' => '01700000000',
                'address' => 'Customer Address',
                'user_type' => 3,
                'status' => 1,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
