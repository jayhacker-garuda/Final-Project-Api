<?php

namespace App\Http\Controllers\api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ],401);
        }else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $credentials = $request->only(['email', 'password']);


            if(auth()->attempt($credentials)){
                $token = $user->createToken($user->email.'_token', ['user'])->plainTextToken;

                return response()->json([
                    'status' => 200,
                    'body' => ['user' => auth()->user(), 'token' => $token],
                    'message' => 'Registration successful'
                ]);
            }

        }

   }
}