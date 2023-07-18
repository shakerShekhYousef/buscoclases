<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * admin login
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'remember' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 500);
        }
        $data = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];
        $remember = false;
        if ($request['remember'] != null) {
            $remember = $request['remember'];
        }
        if (Auth::attempt($data, $remember)) {
            $user = User::find(auth()->user()->id);
            $token = $user->createToken('api_token')->accessToken;

            return response()->json(['status' => 1, 'data' => ['user' => $user, 'token' => $token, 'remember_token' => $user->remember_token]]);
        }

        return response()->json(['status' => 0, 'message' => 'authentication failed'], 500);
    }

    /**
     * login with remember token
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function remember_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|exists:users,remember_token',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 500);
        }
        $user = User::where('remember_token', $request['token'])->first();
        if ($user != null) {
            Auth::login($user);
            $token = $user->createToken('api_token')->accessToken;

            return response()->json(['status' => 1, 'data' => ['user' => $user, 'token' => $token]]);
        }

        return response()->json(['status' => 0, 'message' => 'authentication failed'], 500);
    }
}
