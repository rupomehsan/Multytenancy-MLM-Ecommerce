<?php

namespace App\Modules\MLM\Managements\Commissions\Database\Seeder;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Modules\MLM\Managements\Commissions\Database\Models\CommissionSettingsModel;

class CommissionSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Idempotent seed: create default settings if none exist, otherwise update safely.
        try {
            $defaults = [
                'level_1_percentage' => 10.00,
                'level_2_percentage' => 5.00,
                'level_3_percentage' => 2.00,
                'minimum_withdrawal' => 500.00,
            ];

            $settings = CommissionSettingsModel::first();

            if (!$settings) {
                CommissionSettingsModel::create(array_merge($defaults, [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]));
            } else {
                $settings->update(array_merge($defaults, [
                    'updated_at' => Carbon::now(),
                ]));
            }
        } catch (\Exception $e) {
            // Log but don't fail seeding process
            logger()->error('CommissionSettingsSeeder failed: ' . $e->getMessage());
        }
    }
}
