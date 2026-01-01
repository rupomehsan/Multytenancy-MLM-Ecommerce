<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Seeder\Seeder as UserSeeder;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder\LocationSeeder;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder\ConfigSetupSeeder;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder\EmailConfigureSeeder;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder\PaymentGatewaySeeder;
use App\Modules\MLM\Managements\Commissions\Database\Seeder\CommissionSettingsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call complete account groups seeder (creates account_types, groups, subsidiaries)
        $this->call([
            CompleteAccountGroupsSeeder::class,
            UserSeeder::class,
            LocationSeeder::class,
            ConfigSetupSeeder::class,
            EmailConfigureSeeder::class,
            PaymentGatewaySeeder::class,
            CommissionSettingsSeeder::class,
        ]);

        // Keep existing ac_accounts data
        DB::table("ac_accounts")->insert([
            'account_name' => 'asset',
            'account_code' => '1',
        ]);
        DB::table("ac_accounts")->insert([
            'account_name' => 'liability',
            'account_code' => '2',
        ]);
        DB::table("ac_accounts")->insert([
            'account_name' => 'owner_equity',
            'account_code' => '3',
        ]);
        DB::table("ac_accounts")->insert([
            'account_name' => 'revenue',
            'account_code' => '4',
        ]);
        DB::table("ac_accounts")->insert([
            'account_name' => 'expense',
            'account_code' => '5',
        ]);
    }
}
