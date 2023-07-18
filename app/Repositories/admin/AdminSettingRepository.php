<?php

namespace App\Repositories\admin;

use App\Exceptions\GeneralException;
use App\Models\AdminSetting;
use App\Repositories\BaseRepository;
use App\Trait\FileTrait;
use Illuminate\Support\Facades\DB;

class AdminSettingRepository extends BaseRepository
{
    use FileTrait;

    public function model()
    {
        return AdminSetting::class;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data){
            $settings = AdminSetting::query()->first();
            $settings->update([
                'title'=>$data['title'] ?? $settings->title,
                'logo'=>$data['logo'] ? $this->upload($data['logo'],'images/admin') : $settings->logo
            ]);
            return $settings;
        });
        throw new GeneralException('error');
    }
}
