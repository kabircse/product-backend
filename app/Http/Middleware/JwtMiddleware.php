<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['error' => 1,'statusCode' => 401, 'message' => 'Token is Invalid, please log out and then sign in', 'data' => ""]);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['error' => 1,'statusCode' => 401, 'message' => 'Token is Expired, please log out and then sign in', 'data' => ""]);
            }else{
                return response()->json(['error' => 1,'statusCode' => 401, 'message' =>'Authorization Token not found, please log out and then sign in', 'data' => ""]);
            }
        }
        return $next($request);
    }
}
