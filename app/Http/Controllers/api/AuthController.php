<?php

namespace App\Http\Controllers\api;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\Auth\LinkedinLoginRequest;
use App\Http\Requests\api\Auth\LoginAppleRequest;
use App\Models\Setting;
use App\Models\User;
use App\Trait\ResponseTrait;
use App\Trait\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ResponseTrait, UserTrait;

    /**
     * register new user
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable',
            'phone' => 'required|numeric|unique:users,phone',
            'account_type' => 'required',
            'google_id' => 'nullable|unique:users,google_id',
            'facebook_id' => 'nullable|unique:users,facebook_id',
            'linkedin_id' => 'nullable|unique:users,linkedin_id',
            'access_token' => 'nullable',
            'image' => 'nullable|mimes:jpg,png,jpeg,gif',
            'photo' => 'nullable',
        ]);
        $data = [
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'account_type' => $request['account_type'],
        ];
        if ($request['google_id'] != null) {
            $data['google_id'] = $request['google_id'];
        }
        if ($request['facebook_id'] != null) {
            $data['facebook_id'] = $request['facebook_id'];
        }
        if ($request['linkedin_id'] != null) {
            $data['linkedin_id'] = $request['linkedin_id'];
        }
        if ($request['access_token'] != null) {
            $data['access_token'] = $request['access_token'];
        }
        $user = User::create($data);
        if ($user) {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time().'.'.$file->getClientOriginalExtension();
                $path = $file->storeAs('users', $fileName, 'public');
                $user->image = $path;
                $user->save();
            } elseif ($request['photo'] != null) {
                $user->image = $request['photo'];
                $user->save();
            }
            Auth::login($user);
            $token = $user->createToken('api_token')->accessToken;
            Setting::create(['user_id'=>$user->id]);
            return response()->json(['status' => 1, 'data' => ['user' => $user, 'token' => $token]]);
        }

        return response()->json(['status' => 0, 'message' => 'server error'], 500);
    }

    /**
     * login
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email|exists:users,email',
            'phone' => 'nullable|exists:users,phone',
            'password' => 'required',
            'remember' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 500);
        }
        if ($request['email'] == null && $request['phone'] == null) {
            return response()->json(['status' => 0, 'message' => 'please enter email or phone number'], 500);
        }
        $rememeber = false;
        if ($request['remember'] != null) {
            $rememeber = $request['remember'];
        }
        if ($request['email'] != null) {
            if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']], $rememeber)) {
                $user = User::where('email', $request['email'])->first();
                $token = $user->createToken('api_token')->accessToken;
                $profile = $this->profile($user);

                return response()->json(['status' => 1, 'data' => ['user' => $profile, 'token' => $token, 'remember_token' => $user->remember_token]]);
            }
        }
        if ($request['phone'] != null) {
            $user = User::where('phone', $request['phone'])->first();
            if (Hash::check($request['password'], $user->password)) {
                Auth::login($user, $rememeber);
                $token = $user->createToken('api_token')->accessToken;
                $profile = $this->profile($user);

                return response()->json(['status' => 1, 'data' => ['user' => $profile, 'token' => $token, 'remember_token' => $user->remember_token]]);
            }
        }

        return response()->json(['status' => 0, 'message' => 'authentication failed'], 500);
    }

    /**
     * login with remember token
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login_remember(Request $request)
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
            $profile = $this->profile($user);

            return response()->json(['status' => 1, 'data' => ['user' => $profile, 'token' => $token]]);
        }

        return response()->json(['status' => 0, 'message' => 'authentication failed'], 500);
    }

    /**
     * login with google
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login_google(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'google_id' => 'required',
            'access_token' => 'required',
        ]);
        if ($validator->fails()) {
            return error_response($validator->errors()->first());
        }
        $user = User::where('google_id', $request['google_id'])->first();

        if ($user != null) {
            Auth::login($user);
            $token = $user->createToken('api_token')->accessToken;
            $profile = $this->profile($user);

            return success_response(['user' => $profile, 'token' => $token]);
        }

        return error_response('account not found, please register first');
    }

    /**
     * facebook login
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login_facebook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'facebook_id' => 'required',
            'access_token' => 'required',
        ]);
        if ($validator->fails()) {
            return error_response($validator->errors()->first());
        }
        $user = User::where('facebook_id', $request['facebook_id'])->first();
        if ($user != null) {
            Auth::login($user);
            $profile = $this->profile($user);
            $token = $user->createToken('api_token')->accessToken;

            return success_response(['user' => $profile, 'token' => $token]);
        }

        return error_response('account not found, please register first');
    }

    /**
     * login with linkedin
     *
     * @param  LinkedinLoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login_linkedin(LinkedinLoginRequest $request)
    {
        $url = 'https://api.linkedin.com/v2/me';
        $response = Http::get($url, 'oauth2_access_token='.$request->access_token);
        if ($response->failed()) {
            return [
                'status' => 0,
                'message' => 'error sending request',
            ];
        }
        $responseData = [
            'name' => $response['localizedFirstName'],
            'surname' => $response['localizedLastName'],
            'id' => $response['id'],
        ];
        $user = User::where('linkedin_id', $responseData['id'])->first();
        if ($user != null) {
            $token = $user->createToken('api_token')->accessToken;
            $profile = $this->profile($user);
            $data = ['token' => $token, 'user' => $profile];

            return $this->success($data);
        }

        return $this->success($responseData);
    }

    /**
     * login with apple
     *
     * @param  LoginAppleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function apple_login(LoginAppleRequest $request)
    {
        $user = User::where('email', $request['email'])->first();
        if ($user) {
            Auth::login($user);
            $token = $user->createToken('api_token')->accessToken;
            $profile = $this->profile($user);

            return $this->success(['user' => $profile, 'token' => $token]);
        }
        if ($request['account_type'] == null) {
            throw new GeneralException('account type required');
        }
        $user = User::create($request->all());
        if ($user) {
            $token = $user->createToken('api_token')->accessToken;
            $profile = $this->profile($user);

            return $this->success(['user' => $profile, 'token' => $token]);
        }
        throw new GeneralException('error');
    }
}
