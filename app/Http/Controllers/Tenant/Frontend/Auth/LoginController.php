<?php

namespace App\Http\Controllers\Tenant\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * The guard to be used for authentication.
     *
     * @var string
     */
    protected $guard = 'customer';

    /**
     * Where to redirect users after login.
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
        // Guest middleware will check the URL path and redirect appropriately
        $this->middleware('guest:customer')->except('logout');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Get the post-login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        // Always redirect customers to their dashboard
        return route('customer.home');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('tenant.frontend.auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();

            // Do NOT regenerate session to avoid invalidating other guard's CSRF tokens
            // $request->session()->regenerate();

            $this->clearLoginAttempts($request);

            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Redirect based on user_type
        // 1 => Admin, 2 => User/Shop - redirect to admin dashboard
        if (in_array($user->user_type, [1, 2])) {
            return redirect()->route('admin.dashboard');
        }

        // 3 => Customer - redirect to customer dashboard
        if ($user->user_type == 3) {
            return redirect()->route('customer.home');
        }

        // Fallback to default route
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Only logout from customer guard
        $this->guard()->logout();

        // Do NOT invalidate the entire session or regenerate token
        // This allows admin to stay logged in

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
