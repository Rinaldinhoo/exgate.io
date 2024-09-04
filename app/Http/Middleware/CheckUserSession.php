<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (Session::getId() !== $user->session_id) {
                Auth::logout();
                // return redirect('/login')->withErrors(['loginError' => 'Sua sessão foi encerrada porque você fez login em outro dispositivo.']);
                return redirect('/login');
            }
        }

        return $next($request);
    }
}
