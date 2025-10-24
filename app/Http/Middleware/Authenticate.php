<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->routeIs('dashboard.login-form')) {
                return $next($request);
            }

            return redirect()->route('dashboard.login-form');
        }
        $user = auth()->user();

        if (!in_array($user->user_type, ['SuperAdmin', 'Employee'])) {
            Log::warning('User with ID ' . $user->id . ' is not active and was redirected to login page. Status: ' . $user->status);

            toastr()->error('حسابك ليس حساب مدير أو موظف , لا يمكنك الدخول إلى لوحة التحكم');

            return redirect()->route('dashboard.login-form');
        }

        return $next($request);
    }
}
