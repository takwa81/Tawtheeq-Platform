<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStore
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->user_type === 'Store') {
            return $next($request);
        }

        return response()->json([
            'message' => __('messages.only_Store_allowed')
        ], 403);
    }
}
