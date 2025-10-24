<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVet
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->user_type === 'Vet') {
            return $next($request);
        }

        return response()->json([
            'message' => __('messages.only_vet_allowed')
        ], 403);
    }
}
