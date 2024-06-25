<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json('Please enter all details', 400);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
           return \response()->json('The credentials are incorrect',400);
        }

        return \response()->json([
            'token' => $user->createToken(time())->plainTextToken,
            'user' => $user
        ], 200);
    }

    public function mobileLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
        ]);

        if($validator->fails()){
            return response()->json('Please enter OTP', 400);
        }

        if($request->otp == "123456"){
            $user = User::where('email', 'ekene@ennovateventures.co')->first();

            return \response()->json([
                'token' => $user->createToken(time())->plainTextToken,
                'user' => $user,
                'project_id' => 1
            ], 200);
        }

        return \response()->json('The credentials are incorrect',400);
    }
}
