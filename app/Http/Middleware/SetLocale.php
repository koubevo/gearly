<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $availableLanguages = config('app.available_languages', ['en', 'cs']);
        $preferred = $request->getPreferredLanguage($availableLanguages);

        if (Auth::check()) {
            $locale = Auth::user()->lang ?? $preferred ?? 'en';
        } elseif (!$request->session()->has('locale')) {
            $locale = $preferred ?? 'en';
            $request->session()->put('locale', $locale);
        } else {
            $locale = $request->session()->get('locale', 'en');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
