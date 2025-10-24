<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EmployeeAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('dashboard.login-form');
        }

        $user = Auth::user();

        if ($user->status !== 'active') {
            toastr()->error('حسابك مقفل، تواصل مع الإدارة.');

            return redirect()->route('dashboard.login-form');
        }

        return $next($request);
    }
}
