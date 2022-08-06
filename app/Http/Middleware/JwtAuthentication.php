<?php

namespace App\Http\Middleware;

use Closure;
    use JWTAuth;
    use Exception;
    use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use App\Helpers\HttpStatus;
class JwtAuthentication extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::debug(__CLASS__."::".__FUNCTION__." At Middleware : ");
        try {
            if(!JWTAuth::parseToken()->authenticate()){
                Log::error(__CLASS__."::".__FUNCTION__." Faild To login : ");
                return returnResponse(HttpStatus::$text[HttpStatus::HTTP_UNAUTHORIZED], HttpStatus::HTTP_UNAUTHORIZED, HttpStatus::HTTP_ERROR);
            }
        } catch (Exception $exc) {
            if($exc instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                Log::error(__CLASS__."::".__FUNCTION__." Exception : ".$exc->getMessage());
                return returnResponse(HttpStatus::$text[HttpStatus::INVALID_TOKEN], HttpStatus::INVALID_TOKEN, HttpStatus::HTTP_ERROR);
                
            }
            else if($exc instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                Log::error(__CLASS__."::".__FUNCTION__." Exception : ".$exc->getMessage());
                return returnResponse(HttpStatus::$text[HttpStatus::TOKEN_EXPIRED], HttpStatus::HTTP_BAD_REQUEST, HttpStatus::HTTP_ERROR);
            }
            else{
                    //return response()->json(['status' => 'Authorization Token not found']);
                Log::error(__CLASS__."::".__FUNCTION__." Exception : ".$exc->getMessage());
                    return returnResponse('Authorization Token not found', HttpStatus::HTTP_BAD_REQUEST, HttpStatus::HTTP_ERROR);
                }
            
        }
        return $next($request);
    }
}
