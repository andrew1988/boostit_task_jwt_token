<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

class authJWT
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
          $user = JWTAuth::toUser($request->input('token'));
       } catch (Exception $e) {
          if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
              return response()->json(['error'=>'Token invalid']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
              return response()->json(['error'=>'Token expirat']);
            }else{
              return response()->json(['error'=>'ceva ciudat se intampla, sau, foarte probabil nu esti logat']);
            }
      }
      return $next($request);
  }

}
