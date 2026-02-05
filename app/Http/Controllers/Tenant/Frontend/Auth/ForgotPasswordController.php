<?php

namespace App\Http\Controllers\Tenant\Frontend\Auth;

use Carbon\Carbon;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Mail\ForgotEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmailConfigure;
use App\Mail\UserVerificationMail;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function userForgetPassword()
    {
        // If user is already logged in, redirect to customer home/dashboard
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.home');
        }
        
        return view('tenant.frontend.auth.forget_password');
    }

    public function sendForgetPasswordCode(Request $request)
    {
        // Redirect logged-in users
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.home');
        }
        
        $request->validate([
            'email' => ['required', 'string', 'max:255'],
        ]);

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $this->sendEmailCode($request);
        } else {
            return $this->sendSmsCode($request);
        }
    }

    private function sendEmailCode(Request $request)
    {
        $userInfo = User::where('email', $request->email)->first();
        if (!$userInfo) {
            Toastr::error('No Account Found with this email', 'Failed');
            return back()->withInput();
        }

        $randomCode = rand(100000, 999999);
        $userInfo->verification_code = $randomCode;
        $userInfo->save();

        $emailConfig = DB::table('email_configures')->where('status', 1)->orderBy('id', 'desc')->first();

        if (!$emailConfig) {
            Toastr::error('Email service is not configured. Please contact support.', 'Configuration Error');
            return back()->withInput();
        }

        // Decrypt password (same as RegisterController)
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

        // Set mail config dynamically
        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => trim($emailConfig->host),
            'mail.mailers.smtp.port' => $emailConfig->port,
            'mail.mailers.smtp.username' => $emailConfig->email,
            'mail.mailers.smtp.password' => $decryption ?: $emailConfig->password,
            'mail.mailers.smtp.encryption' => $emailConfig->encryption == 1 ? 'tls' : ($emailConfig->encryption == 2 ? 'ssl' : null),
            'mail.from.address' => $emailConfig->email,
            'mail.from.name' => $emailConfig->mail_from_name ?? config('app.name'),
        ]);

        // Reinitialize mail manager to apply new config
        app()->forgetInstance('mail.manager');
        app()->forgetInstance('mailer');

        try {
            Mail::to(trim($userInfo->email))->send(new ForgotEmail($userInfo));
            
            session(['username' => $request->email]);
            Toastr::success('Password reset code sent successfully. Please check your email!', 'Email Sent');
            return redirect()->route('NewPasswordPage');
        } catch (\Swift_TransportException $e) {
            Log::error('Forgot Password Email Error: ' . $e->getMessage(), [
                'user_email' => $request->email,
                'exception' => $e
            ]);
            
            if (str_contains($e->getMessage(), 'Username and Password not accepted') || 
                str_contains($e->getMessage(), 'BadCredentials')) {
                Toastr::error('Email server authentication failed. Please contact administrator to update email settings (Use Gmail App Password if using Gmail).', 'Configuration Error');
            } else {
                Toastr::error('Failed to send email. Please try again or contact support.', 'Email Error');
            }
            return back()->withInput();
        } catch (\Exception $e) {
            Log::error('Forgot Password Email Error: ' . $e->getMessage(), [
                'user_email' => $request->email,
                'exception' => $e
            ]);
            Toastr::error('Failed to send email. Please try again or contact support.', 'Email Error');
            return back()->withInput();
        }
    }

    private function sendSmsCode(Request $request)
    {
        $userInfo = User::where('phone', $request->email)->first();
        if (!$userInfo) {
            Toastr::error('No Account Found with this phone number', 'Failed');
            return back()->withInput();
        }

        $randomCode = rand(100000, 999999);
        $userInfo->verification_code = $randomCode;
        $userInfo->save();

        $smsGateway = DB::table('sms_gateways')->where('status', 1)->first();
        
        if (!$smsGateway) {
            Toastr::error('SMS service is not configured. Please contact support.', 'Configuration Error');
            return back()->withInput();
        }

        try {
            $response = null;
            
            if ($smsGateway->provider_name == 'Reve') {
                $response = Http::timeout(10)->get($smsGateway->api_endpoint, [
                    'apikey' => $smsGateway->api_key,
                    'secretkey' => $smsGateway->secret_key,
                    "callerID" => $smsGateway->sender_id,
                    "toUser" => $userInfo->phone,
                    "messageContent" => "Your password reset code is: " . $randomCode
                ]);
            } elseif ($smsGateway->provider_name == 'ElitBuzz') {
                $response = Http::timeout(10)->get($smsGateway->api_endpoint, [
                    'api_key' => $smsGateway->api_key,
                    "type" => "text",
                    "contacts" => $userInfo->phone,
                    "senderid" => $smsGateway->sender_id,
                    "msg" => "Your password reset code is: " . $randomCode
                ]);
            } else {
                throw new \Exception('Unsupported SMS provider: ' . $smsGateway->provider_name);
            }

            if (!$response || $response->status() != 200) {
                throw new \Exception('SMS Gateway returned error status: ' . ($response ? $response->status() : 'No response'));
            }

            session(['username' => $request->email]);
            Toastr::success('Password reset code sent successfully. Please check your phone!', 'SMS Sent');
            return redirect()->route('NewPasswordPage');
        } catch (\Exception $e) {
            Log::error('SMS Send Error: ' . $e->getMessage(), [
                'user_phone' => $userInfo->phone ?? 'unknown',
                'exception' => $e
            ]);
            Toastr::error('Failed to send SMS. Please check your phone number or contact support.', 'SMS Error');
            return back()->withInput();
        }
    }

    public function newPasswordPage()
    {
        // Redirect logged-in users
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.home');
        }
        
        if (!session('username')) {
            Toastr::error('Session expired. Please request a new code.', 'Error');
            return redirect()->route('UserForgetPassword');
        }
        return view('tenant.frontend.auth.change_password');
    }

    public function changeForgetPassword(Request $request)
    {
        // Redirect logged-in users
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.home');
        }
        
        $request->validate([
            'code' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255', 'min:8', 'confirmed'],
        ]);

        $username = session('username');
        if (!$username) {
            Toastr::error('Session expired. Please request a new code.', 'Error');
            return redirect()->route('UserForgetPassword');
        }

        $code = $request->code;
        $password = $request->password;

        // Try email first
        $userInfo = User::where('email', $username)->where('verification_code', $code)->first();
        
        // If not found by email, try phone
        if (!$userInfo) {
            $userInfo = User::where('phone', $username)->where('verification_code', $code)->first();
        }

        if ($userInfo) {
            $userInfo->password = Hash::make($password);
            $userInfo->email_verified_at = Carbon::now();
            $userInfo->verification_code = null; // Clear verification code
            $userInfo->save();
            
            Auth::guard('customer')->login($userInfo);
            session()->forget('username'); // Clear session

            Toastr::success('Your password has been changed successfully!', 'Success');
            return redirect()->route('UserDashboard');
        } else {
            Toastr::error('Invalid verification code. Please try again.', 'Failed');
            return back();
        }
    }
}
