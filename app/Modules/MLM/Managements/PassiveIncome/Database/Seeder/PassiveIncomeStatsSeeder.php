<?php

namespace App\Modules\MLM\Managements\PassiveIncome\Database\Seeder;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Modules\MLM\Managements\PassiveIncome\Database\Models\PassiveIncomeStat;

class PassiveIncomeStatsSeeder extends Seeder
{
    public function run()
    {
        // Create a sample stat for demo purposes
        PassiveIncomeStat::truncate();

        PassiveIncomeStat::create([
            'user_id' => null,
            'is_verified_seller' => false,
            'level_1_count' => 1,
            'level_2_count' => 0,
            'level_3_count' => 0,
            'level_4_count' => 0,
            'delivered_orders' => 1,
            'estimated_daily_commission' => 0.00,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
