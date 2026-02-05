<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WithdrawalRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customerId = 67;
        $statuses = ['pending', 'approved', 'rejected', 'processing', 'completed'];
        $methods = ['bKash', 'Nagad', 'Bank Transfer', 'Rocket'];

        for ($i = 1; $i <= 10; $i++) {
            $status = $statuses[array_rand($statuses)];
            $amount = rand(500, 5000);
            $method = $methods[array_rand($methods)];

            DB::table('mlm_withdrawal_requests')->insert([
                'user_id' => $customerId,
                'amount' => $amount,
                'payment_method' => $method,
                'payment_details' => json_encode([
                    'account_number' => '01' . rand(500000000, 999999999),
                    'account_holder' => 'Customer Name',
                ]),
                'status' => $status,
                'processed_by' => null, // Set to null for now
                'processed_at' => in_array($status, ['approved', 'rejected', 'completed']) ? Carbon::now()->subDays(rand(0, 7)) : null,
                'admin_notes' => $status === 'rejected' ? 'Insufficient balance verification' : ($status === 'completed' ? 'Payment processed successfully' : null),
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now()
            ]);
        }

        $this->command->info('Created 10 dummy withdrawal requests for customer ID 67');
    }
}
