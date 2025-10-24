<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ResultTrait;

class CustomAuthenticate
{
    use ResultTrait;
    
    public function handle(Request $request, Closure $next): Response
    {
        $authorization = $request->header('Authorization');

        if (!$authorization || !str_starts_with($authorization, 'Bearer ')) {
            return $this->errorResponse(__('messages.token_required'), null, 401);
        }

        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return $this->errorResponse(__('messages.token_invalid'), null, 401);
        }

        Auth::setUser($user);

        return $next($request);
    }
}
