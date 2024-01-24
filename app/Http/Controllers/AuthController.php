<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actor;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|alpha_num|min:4',
            'password' => 'required|alpha_num|min:6|max:8',
        ]);

        /**
         * individual check of data [usernmae, password]
         */

        $dataByUsernmae = Actor::where('username', $request->username)->first();
        if (!$dataByUsernmae) return response()->json(['error' => 'Invalid username'], 422);

        $dataByPassword = Actor::where('password', md5($request->password))->first();
        if (!$dataByPassword) return response()->json(['error' => 'Invalid password'], 422);


        /**
         * generate token md5
         */

        $token = md5($request->username);
        $dataByPassword->update(['token' => $token]);

        /**
         *  return token only
         */

        return response()->json(['token' => $dataByPassword->token, 'id' => $dataByPassword->id], 200);
    }

    public function logout(Request $request)
    {
        $token = $request->query('token');

        $user = Society::where('login_tokens', $token)->first();

        if (!$user) return Controller::failed('Invalid token');

        $user->update(['login_tokens' => null]);

        return Controller::success('Logout success');
    }
}
