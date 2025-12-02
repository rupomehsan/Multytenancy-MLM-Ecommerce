<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Default to checking web, admin, and customer guards if none specified
        $guards = empty($guards) ? ['web', 'admin', 'customer'] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Check which login page is being accessed
                $isAdminLogin = $request->is('admin/login*');
                $isCustomerLogin = $request->is('login') || $request->is('register');

                // Admin guard: only redirect if accessing admin login
                if ($guard === 'admin' && $isAdminLogin && in_array($user->user_type, [1, 2])) {
                    return redirect()->route('admin.dashboard');
                }

                // Customer guard: only redirect if accessing customer login
                if ($guard === 'customer' && $isCustomerLogin && $user->user_type == 3) {
                    return redirect()->route('UserDashboard');
                }

                // Web guard (legacy): redirect based on user type
                if ($guard === 'web') {
                    if ($isAdminLogin && in_array($user->user_type, [1, 2])) {
                        return redirect()->route('admin.dashboard');
                    }
                    if ($isCustomerLogin && $user->user_type == 3) {
                        return redirect()->route('UserDashboard');
                    }
                }
            }
        }

        return $next($request);
    }
}
