<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user || $user->status !== 'Active') {
            return response()->json([
                'message' => __('messages.account_not_active') 
            ], 403);
        }

        return $next($request);
    }
}
