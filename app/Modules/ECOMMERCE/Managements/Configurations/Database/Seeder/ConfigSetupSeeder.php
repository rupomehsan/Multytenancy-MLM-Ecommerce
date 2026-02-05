<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\ConfigSetup;

class ConfigSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigSetup::truncate();

        $configSetups = [
            [
                'icon' => null,
                'name' => 'Product Size',
                'code' => 'product_size',
                'industry' => 'Fashion',
                'status' => 1,
                'created_at' => Carbon::parse('2023-12-16 18:53:00'),
                'updated_at' => Carbon::parse('2025-04-29 10:06:40'),
            ],
            [
                'icon' => null,
                'name' => 'Product Warranty',
                'code' => 'product_warranty',
                'industry' => 'Tech',
                'status' => 0,
                'created_at' => Carbon::parse('2023-12-16 18:53:00'),
                'updated_at' => Carbon::parse('2025-04-29 10:06:41'),
            ],
            [
                'icon' => null,
                'name' => 'Product Color',
                'code' => 'color',
                'industry' => 'Common',
                'status' => 1,
                'created_at' => Carbon::parse('2024-01-28 19:12:58'),
                'updated_at' => Carbon::parse('2025-04-29 10:06:41'),
            ],
            [
                'icon' => null,
                'name' => 'Measurement Unit',
                'code' => 'measurement_unit',
                'industry' => 'Common',
                'status' => 1,
                'created_at' => Carbon::parse('2024-01-28 19:14:23'),
                'updated_at' => Carbon::parse('2025-04-29 10:06:41'),
            ],
        ];

        foreach ($configSetups as $configSetup) {
            ConfigSetup::create($configSetup);
        }

        $this->command->info('ConfigSetup seeded successfully!');
    }
}
