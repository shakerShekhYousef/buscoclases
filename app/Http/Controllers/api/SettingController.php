<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function showMyNotificationSettings(){
        $auth_id = auth()->id();
        $settings = Setting::query()->where('user_id',$auth_id)->first();
        return success_response($settings);
    }

    public function updateNotificationSettings(Request $request){
        $auth_id = auth()->id();
        $settings = Setting::query()->where('user_id',$auth_id)->first();
        if ($settings){
            $settings->update($request->all());
        }
        return success_response($settings);
    }


}
