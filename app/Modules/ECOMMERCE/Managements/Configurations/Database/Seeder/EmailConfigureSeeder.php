<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\Configurations\Database\Models\EmailConfigure;

class EmailConfigureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

        $this->command->info('EmailConfigure seeded successfully!');
    }
}
