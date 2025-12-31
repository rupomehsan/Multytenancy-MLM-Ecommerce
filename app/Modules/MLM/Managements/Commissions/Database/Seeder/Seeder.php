<?php

namespace App\Modules\MLM\Managements\Commissions\Database\Seeder;

use Illuminate\Database\Seeder as BaseSeeder;

/**
 * Legacy seeder wrapper.
 * This class exists to preserve the original seeder class name but delegates
 * to the idempotent CommissionSettingsSeeder to avoid duplicate logic and errors.
 */
class Seeder extends BaseSeeder
{
    public function run(): void
    {
        $this->call(CommissionSettingsSeeder::class);
    }
}
