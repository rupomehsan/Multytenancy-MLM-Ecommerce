<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if locale is set in session, otherwise use default (bn)
        $locale = Session::get('locale', config('app.locale', 'bn'));
        
        // Validate locale
        if (!in_array($locale, ['en', 'bn'])) {
            $locale = 'bn'; // Default to Bangla
        }
        
        // Set application locale
        App::setLocale($locale);
        
        return $next($request);
    }
}
