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


use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function userForgetPassword()
    {

        return view('tenant.frontend.auth.forget_password');
    }

    public function sendForgetPasswordCode(Request $request)
    {

        $request->validate([
            'email' => ['required', 'string', 'max:255'],
        ]);

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {

            $userInfo = User::where('email', $request->email)->first();
            if (!$userInfo) {
                Toastr::error('No Account Found', '! Failed');
                return back();
            }

            $randomCode = rand(100000, 999999);
            $userInfo->verification_code = $randomCode;
            $userInfo->save();

            $emailConfig = DB::table('email_configures')->where('status', 1)->orderBy('id', 'desc')->first();

            if (!$emailConfig) {
                Toastr::error('No active email configuration found', '! Failed');
                return back();
            }

            $userEmail = trim($userInfo->email);

            if (!$userEmail) {
                Toastr::error('No email provided', '! Failed');
                return back();
            }

            // Set mail config dynamically
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => trim($emailConfig->host),
                'mail.mailers.smtp.port' => $emailConfig->port,
                'mail.mailers.smtp.username' => $emailConfig->email,
                'mail.mailers.smtp.password' => $emailConfig->password,
                'mail.mailers.smtp.encryption' => $emailConfig->encryption == 1 ? 'tls' : ($emailConfig->encryption == 2 ? 'ssl' : null),
                'mail.from.address' => $emailConfig->email,
                'mail.from.name' => $emailConfig->mail_from_name ?? config('app.name'),
            ]);

            // Reinitialize mail manager to apply new config
            app()->forgetInstance('mail.manager');
            app()->forgetInstance('mailer');

            try {
                Mail::to($userEmail)->send(new ForgotEmail($userInfo));
                
                session(['username' => $request->email]);
                Toastr::success('Password Reset Code Sent. Check your email!', 'Success');
                return redirect()->route('NewPasswordPage');
            } catch (\Exception $e) {
                \Log::error('Forgot Password Email Error: ' . $e->getMessage());
                Toastr::error('Failed to send email. Please try again or contact support.', 'Email Error');
                return back()->withInput();
            }
        } else {

            $userInfo = User::where('phone', $request->email)->first();
            if (!$userInfo) {
                Toastr::error('No Account Found', '! Failed');
                return back();
            }

            $randomCode = rand(100000, 999999);
            $userInfo->verification_code = $randomCode;
            $userInfo->save();

                $smsGateway = DB::table('sms_gateways')->where('status', 1)->first();
                if ($smsGateway && $smsGateway->provider_name == 'Reve') {
                    $response = Http::get($smsGateway->api_endpoint, [
                        'apikey' => $smsGateway->api_key,
                        'secretkey' => $smsGateway->secret_key,
                        "callerID" => $smsGateway->sender_id,
                        "toUser" => $userInfo->phone,
                        "messageContent" => "Verification Code is : " . $randomCode
                    ]);

                    if ($response->status() != 200) {
                        Toastr::error('Something Went Wrong', 'Failed to send SMS');
                        return back();
                    }
                } elseif ($smsGateway && $smsGateway->provider_name == 'ElitBuzz') {

                    $response = Http::get($smsGateway->api_endpoint, [
                        'api_key' => $smsGateway->api_key,
                        "type" => "text",
                        "contacts" => $userInfo->phone, //“88017xxxxxxxx,88018xxxxxxxx”
                        "senderid" => $smsGateway->sender_id,
                        "msg" => $randomCode . " is your OTP verification code for shadikorun.com"
                    ]);

                    if ($response->status() != 200) {
                        Toastr::error('Something Went Wrong', 'Failed to send SMS');
                        return back();
                    }
                } else {
                    Toastr::error('No SMS Gateway is Active Now', 'Failed to send SMS');
                    return back();
                }

            session(['username' => $request->email]);

            Toastr::success('Password Reset Code Sent', 'Code Sent Successfully');
            return redirect()->route('NewPasswordPage');
        }
    }

    public function newPasswordPage()
    {
        return view('tenant.frontend.auth.change_password');
    }

    public function changeForgetPassword(Request $request)
    {

        $request->validate([
            'code' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255', 'min:8'],
        ]);

        $username = session('username');
        $code = $request->code;
        $password = $request->password;

        $userInfo = User::where('email', $username)->where('verification_code', $code)->first();
        if ($userInfo) {
            $userInfo->password = Hash::make($password);
            $userInfo->email_verified_at = Carbon::now();
            $userInfo->save();
            Auth::guard('customer')->login($userInfo);

            Toastr::success('Successfully Changed the Password', 'Password Changed');
            return redirect()->route('customer.home');
        } else {

            $userInfo = User::where('phone', $username)->where('verification_code', $code)->first();
            if ($userInfo) {
                $userInfo->password = Hash::make($password);
                $userInfo->email_verified_at = Carbon::now();
                $userInfo->save();
                Auth::guard('customer')->login($userInfo);

                Toastr::success('Successfully Changed the Password', 'Password Changed');
                return redirect()->route('customer.home');
            } else {
                Toastr::error('Wrong Verification Code', 'Try Again');
                return back();
            }
        }
    }
}
