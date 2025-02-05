<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class CheckJwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->session()->get('jwt_token');
            dd($token);

            if (!$token) {
                return response()->view('errors.unauthorized', [], 401);
            }

            $user = JWTAuth::toUser($token);

            $request->auth = $user;

        } catch (JWTException $e) {
            return response()->view('errors.unauthorized', [], 401);
        }

        return $next($request);
    }
}
