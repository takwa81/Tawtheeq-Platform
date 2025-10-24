<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePetOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->user_type === 'PetOwner') {
            return $next($request);
        }

        return response()->json([
            'message' => __('messages.only_pet_owners_allowed')
        ], 403);
    }
}