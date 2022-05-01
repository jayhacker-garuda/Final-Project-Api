<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {

        $validated = $request->validated();
        $credentials = ['email' =>  $validated['email'], 'password' => $validated['password']];

        if(auth()->attempt($credentials)){

            (auth()->user()->user_type === 'admin')
            ? $token = auth()->user()->createToken(auth()->user()->email.'_token', ['admin'])->plainTextToken
            : $token = auth()->user()->createToken(auth()->user()->email.'_token', ['user'])->plainTextToken;

            

            return response()->json([
                'body' => ['user' => auth()->user(), 'token' => $token]
            ], 200);
        }else{
            return response()->json(['error' => trans('auth.failed')], 401);
        }
    }


}