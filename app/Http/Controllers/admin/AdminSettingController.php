<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\AdminSettingRequest;
use App\Models\AdminSetting;
use App\Repositories\admin\AdminSettingRepository;

class AdminSettingController extends Controller
{
    public $adminSettingRepository;

    public function __construct(AdminSettingRepository $adminSettingRepository)
    {
        $this->adminSettingRepository = $adminSettingRepository;
    }

    public function index(){
        $settings = AdminSetting::get();
        return success_response($settings);
    }

    public function store(AdminSettingRequest $request){
        $settings = $this->adminSettingRepository->create($request->all());
        return success_response($settings);
    }
}
