<?php

namespace App\Http\Controllers\Tenant\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserVerificationEmail;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest:customer');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard('customer');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('tenant.frontend.auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // dd($data);
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        // Validate referral code if provided
        if (!empty($data['referral_code'])) {
            $rules['referral_code'] = ['string', 'exists:users,referral_code'];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Generate verification code
        $verificationCode = rand(100000, 999999);

        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 3, // Customer type
            'referral_code' => $this->generateUniqueReferralCode(),
            'verification_code' => $verificationCode,
            'email_verified_at' => null, // User needs to verify email
            'status' => 0, // Inactive until verified
        ];

        // Handle referral code if provided
        if (!empty($data['referral_code'])) {
            $referrer = User::where('referral_code', $data['referral_code'])->first();
            if ($referrer) {
                $userData['referred_by'] = $referrer->id;
            }
        }

        // Add address if provided
        if (!empty($data['address'])) {
            $userData['address'] = $data['address'];
        }

        $user = User::create($userData);

        // Send verification email
        $this->sendVerificationEmail($user, $verificationCode);

        return $user;
    }

    /**
     * Send verification email to the newly registered user
     *
     * @param  User  $user
     * @param  string  $verificationCode
     * @return void
     */
    protected function sendVerificationEmail($user, $verificationCode)
    {
        try {
            // Get active email configuration
            $emailConfig = DB::table('email_configures')
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->first();

            if (!$emailConfig) {
                \Log::warning('No active email configuration found for user registration: ' . $user->email);
                Toastr::warning('Account created but verification email could not be sent. Please contact support.', 'Warning');
                return;
            }

            // Decrypt password
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

            // Configure mail settings dynamically
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

            // Prepare mail data
            $mailData = [
                'name' => $user->name,
                'email' => $user->email,
                'code' => $verificationCode,
                'verification_code' => $verificationCode,
            ];

            // Send email
            Mail::to($user->email)->send(new UserVerificationEmail($mailData));

            \Log::info('Verification email sent successfully to: ' . $user->email);
            Toastr::success('Verification code sent to your email. Please check your inbox.', 'Success');
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            // Show specific error to user
            $errorMsg = 'Account created but email failed: ';
            if (strpos($e->getMessage(), 'Username and Password not accepted') !== false) {
                $errorMsg = 'Account created! However, Gmail authentication failed. Admin must update to use App Password. You can try resending verification email after that.';
            } elseif (strpos($e->getMessage(), 'Connection') !== false) {
                $errorMsg = 'Account created but cannot connect to email server. Please contact support.';
            } else {
                $errorMsg .= 'Please try resending verification code.';
            }

            Toastr::warning($errorMsg, 'Warning');
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // Log the user in automatically after registration
        $this->guard()->login($user);

        // Store email in session for verification page
        session(['username' => $user->email]);

        // Redirect to verification page
        return redirect()->route('UserVerification');
    }

    /**
     * Generate a unique referral code for the user
     *
     * @return string
     */
    protected function generateUniqueReferralCode()
    {
        do {
            $code = 'CUST' . rand(100000, 999999);
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }
}
