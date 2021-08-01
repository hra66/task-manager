<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class ApiAuth
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
        try{
            if(!isset($_COOKIE['api_token'])) {
                return response()->json([
                    'status'=>"fail",
                    'data'=>null,
                    'msg'=>"Unauthorized"
                ],401);
            }else{
                $user = User::where(['api_token'=>$_COOKIE['api_token']])->first();
                if(!$user){
                    return response()->json([
                        'status'=>"fail",
                        'data'=>null,
                        'msg'=>"Unauthorized"
                    ],401);
                }
                $user->save();
                Auth::onceUsingId($user->id);
                return $next($request);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>"fail",
                'data'=>null,
                'msg'=>"Unauthorized"
            ],401);
        }
    }
}
