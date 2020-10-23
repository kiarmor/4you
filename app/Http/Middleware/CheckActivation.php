<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckActivation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->email_confirmed == 1)
                return $next($request);
            else {
                Auth::logout();
                return redirect('login');
            }
        }
        return $next($request);
    }
}
