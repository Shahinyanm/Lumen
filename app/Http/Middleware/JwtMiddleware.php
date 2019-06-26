<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (app()->environment() == 'testing') {
                $user = JWTAuth::setRequest($request)->parseToken()->authenticate();
            }
            $user = JWTAuth::parseToken()->authenticate();
	        Auth::setUser($user);
        }
        catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid'],401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
	            try{
            	$refreshed = JWTAuth::refresh(JWTAuth::getToken());
	            $user = JWTAuth::setToken($refreshed)->toUser();
	            header('Authorization: Bearer ' . $refreshed);
	            }catch(Exception $e){
		            return response()->json(['status' => 'Authorization Token not found']);
	            }
            } else {
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }

	    return $next($request);
    }
}