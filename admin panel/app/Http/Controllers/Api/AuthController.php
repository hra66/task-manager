<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
     /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'data' => null,
                'msg' => "خطا در ورود به سایت",
                'errors' => $validator->errors(),
            ], 400);
        }
       
        $user=User::where(['email'=>trim($request->email)])->first();
        if(!$user){
            return response()->json([
                'status' => 'fail',
                'data' => null,
                'msg' => "چنین کاربری عضو سایت نیست.لطفا عضو شوید",
            ], 400);
        }
        if(!Hash::check($request->password, $user->password)){
            return response()->json([
                'status' => 'fail',
                'data' => null,
                'msg' => "نام کاربری یا کلمه عبور صحیح نیست",
            ], 400);
            
        }
        $user->api_token = Hash::make(time());
        $user->save();
        Auth::login($user);
        setcookie('api_token', $user->api_token, time()+60*60*24*3, "/","",true,true);
        return $this->respondWithToken($user->api_token);
    }
        /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'access_token' => $token,
                'expires_in' => '',
                'user' => [
                    'id' => auth()->user()->id,
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'tasks'=>auth()->user()->tasks,
                ],
            ],
        ], 200);
    }
}
