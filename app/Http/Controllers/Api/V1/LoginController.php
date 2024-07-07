<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }    

        $now = now();
        $random = rand(200,500);
        $value = ''.$request->email.$now.$random;

        $token = $request->user()->createToken($request->device, [''.$value])->plainTextToken;

        return response()->json([
        'token' => $token,
        'message' => 'Success'
        ]);
    } 
  
    public function auth()
    {
        return response()->json(['Error'=>'No validado']);
    }
}
