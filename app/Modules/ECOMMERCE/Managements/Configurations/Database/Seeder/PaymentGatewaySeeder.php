<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

        $this->command->info('PaymentGateway seeded successfully!');
    }
}
