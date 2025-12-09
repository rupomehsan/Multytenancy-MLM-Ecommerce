<?php

namespace App\Modules\MLM\Managements\PassiveIncome\Database\Seeder;

use Illuminate\Database\Seeder;
use App\Modules\MLM\Managements\PassiveIncome\Database\Models\CommissionRate;

class CommissionRateSeeder extends Seeder
{
    public function run()
    {
        CommissionRate::truncate();

        $rates = [
            ['min_price' => 2501, 'max_price' => 10000, 'level_1' => 15, 'level_2' => 10, 'level_3' => 8, 'level_4' => 5, 'sort' => 1],
            ['min_price' => 1501, 'max_price' => 2500, 'level_1' => 10, 'level_2' => 6, 'level_3' => 4, 'level_4' => 3, 'sort' => 2],
            ['min_price' => 1001, 'max_price' => 1500, 'level_1' => 8, 'level_2' => 4, 'level_3' => 3, 'level_4' => 2, 'sort' => 3],
            ['min_price' => 801, 'max_price' => 1000, 'level_1' => 7, 'level_2' => 3, 'level_3' => 2, 'level_4' => 1, 'sort' => 4],
            ['min_price' => 701, 'max_price' => 800, 'level_1' => 6, 'level_2' => 3, 'level_3' => 2, 'level_4' => 1, 'sort' => 5],
            ['min_price' => 601, 'max_price' => 700, 'level_1' => 5, 'level_2' => 3, 'level_3' => 2, 'level_4' => 1, 'sort' => 6],
            ['min_price' => 501, 'max_price' => 600, 'level_1' => 5, 'level_2' => 2, 'level_3' => 2, 'level_4' => 1, 'sort' => 7],
            ['min_price' => 401, 'max_price' => 500, 'level_1' => 4, 'level_2' => 2, 'level_3' => 1, 'level_4' => 1, 'sort' => 8],
            ['min_price' => 301, 'max_price' => 400, 'level_1' => 3, 'level_2' => 2, 'level_3' => 1, 'level_4' => 1, 'sort' => 9],
            ['min_price' => 201, 'max_price' => 300, 'level_1' => 3, 'level_2' => 2, 'level_3' => 1, 'level_4' => 1, 'sort' => 10],
            ['min_price' => 101, 'max_price' => 200, 'level_1' => 2, 'level_2' => 2, 'level_3' => 1, 'level_4' => 1, 'sort' => 11],
            ['min_price' => 0, 'max_price' => 100, 'level_1' => 2, 'level_2' => 1, 'level_3' => 1, 'level_4' => 1, 'sort' => 12],
        ];

        foreach ($rates as $rate) {
            CommissionRate::create([
                'min_price' => $rate['min_price'],
                'max_price' => $rate['max_price'],
                'level_1_commission' => $rate['level_1'],
                'level_2_commission' => $rate['level_2'],
                'level_3_commission' => $rate['level_3'],
                'level_4_commission' => $rate['level_4'],
                'sort_order' => $rate['sort'],
            ]);
        }
    }
}
