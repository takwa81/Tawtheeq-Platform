<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('dashboard.login-form');
        }
        $user = auth()->user();

        if ($user->status !== "active") {

            toastr()->error(__('dashboard.account_not_allowed'));

            return redirect()->route('dashboard.login-form');
        }
        return $next($request);
    }
}
