<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateEmailPassword extends Command
{
    protected $signature = 'email:update-password {password}';
    protected $description = 'Update and encrypt email password for active SMTP configuration';

    public function handle()
    {
        $password = $this->argument('password');

        // Encrypt the password
        $ciphering = "AES-128-CTR";
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = "GenericCommerceV1";

        $encryptedPassword = openssl_encrypt(
            $password,
            $ciphering,
            $encryption_key,
            $options,
            $encryption_iv
        );

        // Update the active email configuration
        $updated = DB::table('email_configures')
            ->where('status', 1)
            ->update(['password' => $encryptedPassword]);

        if ($updated) {
            $config = DB::table('email_configures')->where('status', 1)->first();

            $this->info('✅ Password updated successfully!');
            $this->newLine();
            $this->info('Updated Configuration:');
            $this->info('Email: ' . $config->email);
            $this->info('Host: ' . $config->host);
            $this->info('Port: ' . $config->port);
            $this->newLine();
            $this->info('🧪 Test it now with: php artisan test:email');
        } else {
            $this->error('❌ No active email configuration found to update.');
        }

        return 0;
    }
}
