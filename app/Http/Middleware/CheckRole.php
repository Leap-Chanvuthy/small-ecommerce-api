<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;





class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        try {
            // Get the authenticated user
            $user =  JWTAuth::parseToken()->authenticate();

            // Check if user has the required role
            if (!$user || $user->role !== $role) {
                return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Token is invalid or expired'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
