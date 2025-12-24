<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DiagnoseEmail extends Command
{
    protected $signature = 'email:diagnose';
    protected $description = 'Diagnose email configuration issues';

    public function handle()
    {
        $this->info('🔍 Email Configuration Diagnosis');
        $this->info('================================');
        $this->newLine();

        // Fetch email configuration
        $emailConfig = DB::table('email_configures')->where('status', 1)->orderBy('id', 'desc')->first();

        if (!$emailConfig) {
            $this->error('❌ No active email configuration found in database.');
            $this->info('Please configure SMTP settings in the admin panel.');
            return 1;
        }

        $this->info('📧 Database Configuration:');
        $this->table(
            ['Setting', 'Value'],
            [
                ['Host', $emailConfig->host],
                ['Port', $emailConfig->port],
                ['Username/Email', $emailConfig->email],
                ['Encryption', $emailConfig->encryption == 1 ? 'TLS' : ($emailConfig->encryption == 2 ? 'SSL' : 'None')],
                ['From Name', $emailConfig->mail_from_name ?? 'Not Set'],
                ['Status', $emailConfig->status == 1 ? 'Active' : 'Inactive'],
            ]
        );
        $this->newLine();

        // Check password decryption
        $this->info('🔐 Password Decryption Test:');
        try {
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

            if ($decryption) {
                $this->info('✅ Password decrypted successfully');
                $this->info('   Decrypted length: ' . strlen($decryption) . ' characters');
            } else {
                $this->warn('⚠️  Password decryption returned empty - using raw password');
            }
        } catch (\Exception $e) {
            $this->error('❌ Password decryption failed: ' . $e->getMessage());
        }
        $this->newLine();

        // Gmail specific checks
        if (stripos($emailConfig->host, 'gmail') !== false || stripos($emailConfig->email, 'gmail') !== false) {
            $this->warn('⚠️  Gmail SMTP Detected!');
            $this->newLine();
            $this->info('📝 Gmail SMTP Requirements:');
            $this->info('   1. You MUST use an App Password (not your regular Gmail password)');
            $this->info('   2. Enable 2-Factor Authentication on your Gmail account');
            $this->info('   3. Generate App Password at: https://myaccount.google.com/apppasswords');
            $this->info('   4. Use these settings:');
            $this->info('      - Host: smtp.gmail.com');
            $this->info('      - Port: 587 (TLS) or 465 (SSL)');
            $this->info('      - Encryption: TLS or SSL');
            $this->newLine();

            if ($emailConfig->port != 587 && $emailConfig->port != 465) {
                $this->error('❌ Incorrect port for Gmail. Use 587 (TLS) or 465 (SSL)');
            }

            if ($emailConfig->encryption == 0) {
                $this->error('❌ Gmail requires encryption. Enable TLS or SSL');
            }
        }

        // General recommendations
        $this->newLine();
        $this->info('💡 Troubleshooting Tips:');
        $this->info('   • For Gmail: Use App Password, not regular password');
        $this->info('   • Check if firewall allows outbound SMTP connections');
        $this->info('   • Verify email and password are correct');
        $this->info('   • Test with command: php artisan test:email');
        $this->newLine();

        return 0;
    }
}
