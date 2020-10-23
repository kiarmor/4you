<?php
    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Support\Facades\Auth;

    class IsAdmin
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return mixed
         */
        public function handle($request, Closure $next)
        {
            $user = Auth::user();
            if (Auth::user()->isadmin)
                return $next($request);
            else
                return redirect('/');
        }
    }
?> 