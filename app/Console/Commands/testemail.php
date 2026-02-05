<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Illuminate\Console\Command;

class testemail extends Command
{
    protected $signature = 'test:email';
    protected $description = 'Send a test email using dynamic SMTP settings';

    public function handle()
    {
        $emailConfig = DB::table('email_configures')->where('status', 1)->orderBy('id', 'desc')->first();

        if (!$emailConfig) {
            $this->error('❌ No active email configuration found.');
            return;
        }

        // Decrypt password if encrypted
        $decryption = "";
        if ($emailConfig->password) {
            $ciphering = "AES-128-CTR";
            $options = 0;
            $decryption_iv = '1234567891011121';
            $decryption_key = "GenericCommerceV1";
            $decryption = openssl_decrypt(
                $emailConfig->password,
                $ciphering,
                $decryption_key,
                $options,
                $decryption_iv
            );
        }

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => trim($emailConfig->host),
            'mail.mailers.smtp.port' => $emailConfig->port,
            'mail.mailers.smtp.username' => $emailConfig->email,
            'mail.mailers.smtp.password' => $decryption ?: $emailConfig->password,
            'mail.mailers.smtp.encryption' => $emailConfig->encryption == 1 ? 'tls' : ($emailConfig->encryption == 2 ? 'ssl' : null),
            'mail.from.address' => $emailConfig->email,
            'mail.from.name' => $emailConfig->mail_from_name ?: 'Test Mailer',
        ]);

        $this->info('📧 Email Configuration:');
        $this->info('Host: ' . $emailConfig->host);
        $this->info('Port: ' . $emailConfig->port);
        $this->info('Username: ' . $emailConfig->email);
        $this->info('Encryption: ' . ($emailConfig->encryption == 1 ? 'TLS' : ($emailConfig->encryption == 2 ? 'SSL' : 'None')));
        $this->info('');

        $testEmail = $this->ask('Enter recipient email address for test', 'test@example.com');

        try {
            Mail::raw('✅ Test email from Laravel SMTP configuration. If you receive this, your email setup is working correctly!', function ($msg) use ($testEmail) {
                $msg->to($testEmail)
                    ->subject('Test Email - SMTP Configuration');
            });

            $this->info('✅ Test email sent successfully to: ' . $testEmail);
        } catch (\Exception $e) {
            $this->error('❌ Failed to send email: ' . $e->getMessage());
        }
    }
}
