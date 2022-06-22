<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $th) {
            try{
                $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                $user = JWTAuth::setToken($refreshed->toUser());
                $request->headers->set('Authorization','Bearer'.$refreshed);
            }catch(JWTException $e){
               
               if($th instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token Invalido']);
                }else if($th instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token Expirado']);
                }else {
                return response()->json(['code' => 103,
                'message' => 'Token no puede ser Refrescado, Inicie Sesion Nuevamente']);
                }
            }
        }
        return $next($request);
    }
}
