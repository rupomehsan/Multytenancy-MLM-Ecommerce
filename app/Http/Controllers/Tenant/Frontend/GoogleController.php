<?php

namespace App\Http\Controllers\Tenant\Frontend;

use Illuminate\Http\Request;
use Socialite;
use Exception;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;

use App\Http\Controllers\Controller;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        $socialLoginCredentials = DB::table('social_logins')->where('id', 1)->first();

        if ($socialLoginCredentials && $socialLoginCredentials->gmail_client_id && $socialLoginCredentials->gmail_secret_id) {
            config([
                'services.google.client_id' => $socialLoginCredentials->gmail_client_id,
                'services.google.client_secret' => $socialLoginCredentials->gmail_secret_id,
                'services.google.redirect' => $socialLoginCredentials->gmail_redirect_url,
            ]);

            return Socialite::driver('google')
                ->redirectUrl($socialLoginCredentials->gmail_redirect_url) // ✅ important
                ->redirect();
        }

        Toastr::error('Google login credentials not found');
        return redirect()->back();
    }

    public function handleGoogleCallback()
    {
        $socialLoginCredentials = DB::table('social_logins')->where('id', 1)->first();

        if ($socialLoginCredentials && $socialLoginCredentials->gmail_client_id && $socialLoginCredentials->gmail_secret_id) {
            config([
                'services.google.client_id' => $socialLoginCredentials->gmail_client_id,
                'services.google.client_secret' => $socialLoginCredentials->gmail_secret_id,
                'services.google.redirect' => $socialLoginCredentials->gmail_redirect_url,
            ]);
        }

        try {
            $user = Socialite::driver('google')
                ->redirectUrl(config('services.google.redirect')) // ✅ important
                ->user();

            $finduser = User::where('provider_id', $user->id)->first();
            $emailUser = User::where('email', $user->email)->first();

            if ($finduser) {
                Auth::login($finduser);

                if (session('last_visited_url')) {
                    return redirect(session('last_visited_url'));
                }

                return session('cart') && count(session('cart')) > 0
                    ? redirect('/checkout')
                    : redirect('/home');
            } elseif ($emailUser) {
                // If the user exists but not linked with provider_id
                $emailUser->update([
                    'provider_name' => 'google',
                    'provider_id' => $user->id,
                ]);
                Auth::login($emailUser);
                return session('cart') && count(session('cart')) > 0
                    ? redirect('/checkout')
                    : redirect('/home');
            } else {
                $newUserId = User::insertGetId([
                    'name' => $user->name,
                    'email' => $user->email,
                    'provider_name' => 'google',
                    'provider_id' => $user->id,
                    'password' => Hash::make('GetMarried1234'),
                    'user_type' => 3,
                    'status' => 1,
                    'email_verified_at' => Carbon::now()
                ]);

                $userInfo = User::find($newUserId);
                Auth::login($userInfo);

                return session('cart') && count(session('cart')) > 0
                    ? redirect('/checkout')
                    : redirect('/home');
            }
        } catch (Exception $e) {
            // dd($e->getMessage()); // ✅ useful during debug
            Toastr::error('Manual Account Created with this Email', 'Try Login with Password');
            return redirect(env('APP_URL'));
        }
    }
}
