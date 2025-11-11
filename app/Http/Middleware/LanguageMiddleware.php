<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $lang = 'en';

        if (auth()->check() && in_array(auth()->user()->preferred_lang, ['en', 'ar'])) {
            $lang = auth()->user()->preferred_lang;
        }
        elseif (Session::has('app_locale') && in_array(Session::get('app_locale'), ['en', 'ar'])) {
            $lang = Session::get('app_locale');
        }

        // Set the application locale
        App::setLocale($lang);

        return $next($request);
    }
}
