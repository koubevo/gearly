<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UpdateLastLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (!$user->last_login_at || now()->diffInMinutes($user->last_login_at) < -60) {
                $user->last_login_at = now();
                $user->save();
            }
        }

        return $next($request);
    }
}