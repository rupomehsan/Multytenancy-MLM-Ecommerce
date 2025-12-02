<?php

namespace App\Http\Middleware;

use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRolePermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check admin guard first, then web guard for backward compatibility
        $user = Auth::guard('admin')->user() ?? Auth::guard('web')->user();

        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Check if user account is inactive
        if ($user->status == 0) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Your account has been deactivated.']);
        }

        // User type 3 (Customer) - redirect to customer dashboard
        if ($user->user_type == 3) {
            return redirect()->route('customer.home')
                ->with('error', 'You do not have permission to access the admin panel.');
        }

        // User type 1 (Admin) - full access
        if ($user->user_type == 1) {
            return $next($request);
        }

        // User type 2 (User/Shop) - role-based access
        if ($user->user_type == 2) {
            if (UserRolePermission::where('user_id', $user->id)
                ->where('route', $request->route()->uri())
                ->exists()
            ) {
                return $next($request);
            }

            return redirect()->route('admin.dashboard')
                ->with('error', 'You do not have permission to access this resource.');
        }

        // Invalid user type - logout and redirect
        auth()->logout();
        return redirect()->route('login')
            ->withErrors(['email' => 'Invalid user type.']);
    }
}
