<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Actor;

class TokenValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->query('token');

        if(!$token) return response()->json(['message' => 'Unauthorized user'], 401);

        $val = Actor::where('token', $token)->first();

        if(!$val) return response()->json(['message' => 'Invalid token'], 401);

        return $next($request);
    }
}
