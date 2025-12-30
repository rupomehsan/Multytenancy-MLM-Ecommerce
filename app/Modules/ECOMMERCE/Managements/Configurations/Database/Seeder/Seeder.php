<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\ConfigSetup;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\EmailConfigure;
use App\Models\PaymentGateway;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class="\App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder\Seeder"
     */

    public function run(): void
    {
        $faker = Faker::create();

        // Seed Config Setups
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

        // Seed Email Configures
        EmailConfigure::truncate();
        $emailConfigures = [
            [
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'email' => 'rupomehsan34@gmail.com',
                'password' => 'obxPMLnYKiuRtO6nSA350g==',
                'mail_from_name' => 'Amazing Family Hub',
                'mail_from_email' => 'rupomehsan34@gmail.com',
                'encryption' => 1,
                'slug' => '1765173329QoPNX',
                'status' => 0,
                'created_at' => Carbon::parse('2025-12-08 11:55:29'),
                'updated_at' => Carbon::parse('2025-12-08 17:03:40'),
            ],
        ];

        foreach ($emailConfigures as $emailConfigure) {
            EmailConfigure::create($emailConfigure);
        }

        // Seed Payment Gateways
        PaymentGateway::truncate();
        $paymentGateways = [
            [
                'provider_name' => 'ssl_commerz',
                'api_key' => 'ajmai67811839e634e',
                'secret_key' => 'ajmai67811839e634e@ssl',
                'username' => 'ajmain',
                'password' => '12345678',
                'live' => 0,
                'status' => 1,
                'created_at' => null,
                'updated_at' => Carbon::parse('2025-12-08 17:53:54'),
            ],

        ];

        foreach ($paymentGateways as $paymentGateway) {
            PaymentGateway::create($paymentGateway);
        }
    }
}
