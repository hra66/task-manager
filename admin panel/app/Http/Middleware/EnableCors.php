<?php

namespace App\Http\Middleware;

use Closure;

class EnableCors
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
        $headers = [
            'Access-Control-Allow-Credentials'=> true,
            //'Access-Control-Allow-Origin' =>'https://admintask.inboxi.net',
            'Access-Control-Allow-Methods'=>' POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=>' Content-Type, Accept, Authorization, X-Requested-With, Cache-Control'
        ];
        if($request->getMethod() == "OPTIONS") {
            return \Response::make('OK', 200, $headers);
        }
        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }
        return $response;
    }
}
