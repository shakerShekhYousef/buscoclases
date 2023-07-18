<?php

namespace App\Http\Controllers\api;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    //save device token
    public function saveDeviceToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firebase_token' => 'required',
        ]);
        if ($validator->fails()) {
            throw new GeneralException($validator->errors());
        }

        $user_id = auth()->user()->id;
        $user_device = Device::where('user_id', $user_id)->where('firebase_token', $request->firebase_token)->first();
        if ($user_device === null) {
            $user_device = Device::create([
                'user_id' => auth('api')->user()->id,
                'firebase_token' => $request->firebase_token,
            ]);
        } else {
            return success_response('Token updated');
        }

        return success_response('Token saved');
    }

    //delete device token
    public function deleteDeviceToken(Request $request)
    {
        try {
            $user_firebasetoken = $request->firebase_token;
            $token_firebase = Device::where('firebase_token', $user_firebasetoken)
                ->where('user_id', auth('api')->user()->id)->first();
            if ($token_firebase) {
                $token_firebase->delete();

                return success_response('Token deleted');
            } else {
                return not_found_response('Token does not exist');
            }
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()], 400);
        }
    }
}
