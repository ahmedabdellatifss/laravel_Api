<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;


class checkAdminToken
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = null;
        try{
            $user = JWTAuth::parseToken()->authenticate();
        }catch(\Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInbalidException) {
                return $this->returnError('E3001' , 'INVALID_TOKEN' );
            }else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->returnError('E3001' , 'EXCPIRED_TOKEN' );
            }else{
                return $this->returnError('E3001' , 'EXCPIRED_NOTFOUND');
            }

        }catch(\Throwable $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInbalidException) {
                return $this->returnError('E3001' , 'INVALID_TOKEN' );
            }else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->returnError('E3001' , 'EXCPIRED_TOKEN' );
            }else{
                return $this->returnError('E3001' , 'EXCPIRED_NOTFOUND');
            }
        }

        if(!$user)
            return $this->returnError('Unauthenticated');
        return $next($request);
    }
}
