<?php

namespace App\Http\Controllers\Tenant\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\UserVerificationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;



use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;



class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    protected $baseRoute = 'tenant.frontend.pages.';

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/my/orders';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:customer');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Get the guard to be used during verification.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard('customer');
    }







    public function userVerification()
    {
        $randomCode = rand(100000, 999999);
        $userInfo = Auth::user();

        if (!$userInfo->email_verified_at && !$userInfo->verification_code) {

            User::where('id', $userInfo->id)->update([
                'verification_code' => $randomCode
            ]);

            if ($userInfo->email) {

                $mailData = array();
                $mailData['code'] = $randomCode;

                $emailConfig = DB::table('email_configures')->where('status', 1)->orderBy('id', 'desc')->first();
                $decryption = "";

                // dd($emailConfig);

                if ($emailConfig) {
                    $ciphering = "AES-128-CTR";
                    $options = 0;
                    $decryption_iv = '1234567891011121';
                    $decryption_key = "GenericCommerceV1";
                    $decryption = openssl_decrypt($emailConfig->password, $ciphering, $decryption_key, $options, $decryption_iv);

                    config([
                        'mail.default' => 'smtp',
                        'mail.mailers.smtp.transport' => 'smtp',
                        'mail.mailers.smtp.host' => trim($emailConfig->host),
                        'mail.mailers.smtp.port' => $emailConfig->port,
                        'mail.mailers.smtp.username' => $emailConfig->email,
                        'mail.mailers.smtp.password' => $decryption ?: $emailConfig->password,
                        'mail.mailers.smtp.encryption' => $emailConfig->encryption == 1 ? 'tls' : ($emailConfig->encryption == 2 ? 'ssl' : null),
                        'mail.from.address' => $emailConfig->email,
                        'mail.from.name' => $emailConfig->mail_from_name ?: config('app.name'),
                    ]);

                    try {
                        Mail::to(trim($userInfo->email))->send(new UserVerificationMail($mailData));
                        \Log::info('Verification email sent successfully to: ' . $userInfo->email);
                    } catch (\Exception $e) {
                        \Log::error('Failed to send verification email: ' . $e->getMessage());
                        \Log::error('Stack trace: ' . $e->getTraceAsString());

                        // Show specific error to user
                        $errorMsg = 'Email sending failed: ';
                        if (strpos($e->getMessage(), 'Username and Password not accepted') !== false) {
                            $errorMsg = 'Gmail authentication failed. You must use an App Password, not your regular Gmail password. See logs for details.';
                        } elseif (strpos($e->getMessage(), 'Connection') !== false) {
                            $errorMsg = 'Cannot connect to SMTP server. Check host and port settings.';
                        } else {
                            $errorMsg .= $e->getMessage();
                        }

                        Toastr::error($errorMsg, 'Email Error');
                    }
                }
            } else {

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
            }

            return view($this->baseRoute . 'customer_panel.pages.verification');
        } elseif (!$userInfo->email_verified_at && $userInfo->verification_code) {
            return view($this->baseRoute . 'customer_panel.pages.verification');
        } else {
            return redirect('/cutomer/home');
        }
    }

    public function userVerificationResend()
    {
        $randomCode = rand(100000, 999999);
        $userInfo = Auth::user();

        if (!$userInfo->email_verified_at) {

            User::where('id', $userInfo->id)->update([
                'verification_code' => $randomCode
            ]);

            if ($userInfo->email) {

                $mailData = array();
                $mailData['code'] = $randomCode;

                $emailConfig = DB::table('email_configures')->where('status', 1)->orderBy('id', 'desc')->first();
                $decryption = "";

                // dd($emailConfig);

                if ($emailConfig) {
                    $ciphering = "AES-128-CTR";
                    $options = 0;
                    $decryption_iv = '1234567891011121';
                    $decryption_key = "GenericCommerceV1";
                    $decryption = openssl_decrypt($emailConfig->password, $ciphering, $decryption_key, $options, $decryption_iv);

                    config([
                        'mail.default' => 'smtp',
                        'mail.mailers.smtp.transport' => 'smtp',
                        'mail.mailers.smtp.host' => trim($emailConfig->host),
                        'mail.mailers.smtp.port' => $emailConfig->port,
                        'mail.mailers.smtp.username' => $emailConfig->email,
                        'mail.mailers.smtp.password' => $decryption ?: $emailConfig->password,
                        'mail.mailers.smtp.encryption' => $emailConfig->encryption == 1 ? 'tls' : ($emailConfig->encryption == 2 ? 'ssl' : null),
                        'mail.from.address' => $emailConfig->email,
                        'mail.from.name' => $emailConfig->mail_from_name ?: config('app.name'),
                    ]);

                    try {
                        Mail::to(trim($userInfo->email))->send(new UserVerificationMail($mailData));
                        \Log::info('Verification email resent successfully to: ' . $userInfo->email);
                    } catch (\Exception $e) {
                        \Log::error('Failed to resend verification email: ' . $e->getMessage());
                        \Log::error('Stack trace: ' . $e->getTraceAsString());

                        // Show specific error to user
                        $errorMsg = 'Email sending failed: ';
                        if (strpos($e->getMessage(), 'Username and Password not accepted') !== false) {
                            $errorMsg = 'Gmail authentication failed. Please update to use Gmail App Password (not regular password).';
                        } elseif (strpos($e->getMessage(), 'Connection') !== false) {
                            $errorMsg = 'Cannot connect to SMTP server. Check host and port settings.';
                        } else {
                            $errorMsg .= substr($e->getMessage(), 0, 200);
                        }

                        Toastr::error($errorMsg, 'Email Error');
                        return back();
                    }
                }
            } else {

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
            }

            Toastr::success('Verification Code Sent', 'Resend Verification Code');
            return back();
        } else {
            return redirect('/customer/home');
        }
    }

    public function userVerifyCheck(Request $request)
    {

        $verificationCode = '';
        foreach ($request->code as $code) {
            $verificationCode .= $code;
        }

        $userInfo = Auth::user();
        if ($userInfo->verification_code == $verificationCode) {
            if ($userInfo->email_verified_at) {
                Toastr::info('User already verified', 'Already Verified');
                return redirect()->route('customer.home');
            }

            User::where('id', $userInfo->id)->update([
                'email_verified_at' => Carbon::now()
            ]);

            Toastr::success('User Verification Complete', 'Successfully Verified');

            // After successful verification, redirect to customer dashboard
            if (session('cart') && count(session('cart')) > 0) {
                return redirect('/checkout');
            } else {
                return redirect()->route('customer.home');
            }
        } else {
            Toastr::error('Wrong Verification Code', 'Failed');
            return back();
        }
    }
}
