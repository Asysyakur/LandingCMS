<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check for Bearer token
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Token required',
                'error' => 'missing_token'
            ], 401);
        }

        // Validate token using Sanctum
        try {
            // Use Sanctum's token validation
            $model = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
            
            if (!$model) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid or expired token',
                    'error' => 'invalid_token'
                ], 401);
            }

            // Get the user associated with the token
            $user = $model->tokenable;

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'error' => 'user_not_found'
                ], 401);
            }

            // Set authenticated user
            Auth::setUser($user);
            $request->setUserResolver(function () use ($user) {
                return $user;
            });

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Authentication failed',
                'error' => 'auth_error'
            ], 401);
        }

        return $next($request);
    }
}
