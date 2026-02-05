<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

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

        $now = Carbon::now();

        // Insert Admin User only if doesn't exist
        if (!DB::table('users')->where('email', 'admin@gmail.com')->exists()) {
            DB::table('users')->insert([
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('11111111'),
                'phone' => '01234567890',
                'address' => 'Admin Address',
                'balance' => 0,
                'user_type' => User::ADMIN,
                'status' => 1,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Insert Shop User only if doesn't exist
        if (!DB::table('users')->where('email', 'shop@gmail.com')->exists()) {
            DB::table('users')->insert([
                'name' => 'Shop User',
                'email' => 'shop@gmail.com',
                'password' => Hash::make('11111111'),
                'phone' => '01987654321',
                'address' => 'Shop Address',
                'balance' => 0,
                'user_type' => User::SYSTEM_USER,
                'status' => 1,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Insert Customer User only if doesn't exist
        if (!DB::table('users')->where('email', 'customer@gmail.com')->exists()) {
            DB::table('users')->insert([
                'name' => 'Delivery Man',
                'email' => 'deliveryman@gmail.com',
                'password' => Hash::make('11111111'),
                'phone' => '01700000000',
                'address' => ' Delivery Man Address',
                'balance' => 0,
                'user_type' => User::DELIVERY_BOY,
                'status' => 1,
                'referral_code' => 'CUST' . rand(100000, 999999),
                'wallet_balance' => 0,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        // ========================================
        // MLM REFERRAL CHAIN STRUCTURE
        // ========================================

        // Check if MLM users already exist
        if (DB::table('users')->where('email', 'level1@mlm.com')->exists()) {
            echo "\n⚠️  MLM users already exist. Skipping creation.\n";
            return;
        }

        // LEVEL 1: Top Referrer (1 user)
        $level1UserId = DB::table('users')->insertGetId([
            'name' => 'Level 1 - Top Referrer',
            'email' => 'level1@mlm.com',
            'password' => Hash::make('11111111'),
            'phone' => '01800000001',
            'address' => 'Level 1 Address',
            'balance' => 0,
            'user_type' => User::CUSTOMER,
            'status' => 1,
            'referral_code' => 'L1REF001',
            'referred_by' => null,
            'wallet_balance' => 0,
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // LEVEL 2: 3 users referred by Level 1
        $level2UserIds = [];

        for ($i = 1; $i <= 3; $i++) {
            $phoneNum = 1800000001 + $i;
            $level2UserIds[] = DB::table('users')->insertGetId([
                'name' => "Level 2 - Referrer {$i}",
                'email' => "level2_{$i}@mlm.com",
                'password' => Hash::make('11111111'),
                'phone' => "0{$phoneNum}",
                'address' => "Level 2 Address {$i}",
                'balance' => 0,
                'user_type' => User::CUSTOMER,
                'status' => 1,
                'referral_code' => "L2REF00{$i}",
                'referred_by' => $level1UserId,
                'wallet_balance' => 0,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // LEVEL 3: 2 users under each Level 2 user (6 users total)
        $counter = 1;
        foreach ($level2UserIds as $index => $level2Id) {
            for ($j = 1; $j <= 2; $j++) {
                DB::table('users')->insert([
                    'name' => "Level 3 - User {$counter}",
                    'email' => "level3_{$counter}@mlm.com",
                    'password' => Hash::make('11111111'),
                    'phone' => "0180000010{$counter}",
                    'address' => "Level 3 Address {$counter}",
                    'balance' => 0,
                    'user_type' => User::CUSTOMER,
                    'status' => 1,
                    'referral_code' => "L3REF00{$counter}",
                    'referred_by' => $level2Id,
                    'wallet_balance' => 0,
                    'email_verified_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $counter++;
            }
        }

        echo "\n✅ MLM Referral Chain Created Successfully!\n";
        echo "   └── Level 1: 1 user (Top Referrer)\n";
        echo "   └── Level 2: 3 users (referred by Level 1)\n";
        echo "   └── Level 3: 6 users (2 under each Level 2 user)\n";
        echo "   Total: 10 MLM users + 3 base users = 13 users\n\n";
    }
}
