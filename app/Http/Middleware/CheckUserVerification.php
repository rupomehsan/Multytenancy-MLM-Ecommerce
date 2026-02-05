<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check customer guard for email verification
        $user = Auth::guard('customer')->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->email_verified_at == null || $user->email_verified_at == '') {
            return redirect('/user/verification');
        }

        return $next($request);
    }
}
