<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Validator;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        
        // set validation
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        // if validation fails
        if($validator->fails()) return response()->json($validator->errors(), 422);

        // get user by username
        $user = User::where('username', $request->input('username'))->first();

        // if user not found
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 401);
        }

        // if password wrong
        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password incorrect'
            ], 401);
        }

        // get credentials
        $credentials = $request->only('username', 'password');

        // if auth failed
        if(!$token = auth()->guard('api')->attempt($credentials)){
            return response()->json([
                'success' => false,
                'message' => 'Username or password wrong'
            ], 401);
        }

        // if auth success
        return response()->json([
            'token' => $token
        ]);


    }

    public function logout(){
        //remove token
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken) {
            //return response JSON
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',  
            ]);
        }
    }
}
