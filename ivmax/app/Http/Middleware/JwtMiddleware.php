<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // HACK - if path is refresh allow route
        $path = $request->route()->getActionName();
        $parts = explode('@', $path);

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid'], Response::HTTP_UNAUTHORIZED);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                if (end($parts) == 'refresh') {
                    return $next($request);
                }

                return response()->json(['status' => 'Token is Expired'], Response::HTTP_BAD_REQUEST);
            }

            return response()->json(['status' => 'Authorization Token not found'], Response::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}
