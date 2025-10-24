<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDeliveryCaptain
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->user_type === 'DeliveryCaptain') {
            return $next($request);
        }

        return response()->json([
            'message' => __('messages.only_Captain_allowed')
        ], 403);
    }
}
