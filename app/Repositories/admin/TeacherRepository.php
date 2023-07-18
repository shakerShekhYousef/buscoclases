<?php

namespace App\Repositories\admin;

use App\Exceptions\GeneralException;
use App\Mail\TeacherInfoMail;
use App\Models\Blacklist;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TeacherRepository
{
    /**
     * get teachers list
     *
     * @return array
     */
    public function all()
    {
        $teachers = Teacher::query()->with('documents')->get();
        foreach ($teachers as $teacher){
            $settings = Setting::query()->where('user_id',$teacher->id)->first();
            $teacher['settings'] = $settings;
            $block_teacher = Blacklist::query()->where('teacher_id',$teacher->id)->first();
            $block = !($block_teacher == null);
            $teacher['is_blocked'] = $block;
        }
        return $teachers;
    }

    public function create(array $data){
        return DB::transaction(function () use ($data){
            if ($data['generate_password'] == 1){
                $password = Str::random(10);
            }else{
                $password = $data['password'];
            }
            if ($data['send_email'] == 1){
                Mail::to($data['email_to_send'])->send(new TeacherInfoMail($data['email'],$password));
            }
            $user = User::create([
                'email'=>$data['email'],
                'password'=>Hash::make($password),
                'account_type'=>'teacher',
                'role_id'=>3
            ]);
            $teacherData = [
                'id' => $user->id,
                'name' => $data['name'],
                'surname' => $data['surname'],
                'birth_date' => $data['birth_date'],
                'province' => $data['province'],
                'city' => $data['city'],
                'postal_code' => $data['postal_code'],
                'gender' => $data['gender'],
                'user_id' => $user->id,
                'email' => $data['email'],
                'phone' => $data['phone'],
                'about' => $data['about'],
                'nationality' => $data['nationality'],
                'lat' => isset($data['lat']) ? $data['lat'] : 40.36949723375373,
                'lng' => isset($data['lng']) ? $data['lng'] : -3.7077597698552545,
                'has_car' => $data['has_car'],
                'has_license' => $data['has_license'],
                'generate_password'=>$data['generate_password'],
                'change_password'=>$data['change_password'],
                'send_email'=>$data['send_email']
            ];
            $teacher = Teacher::create($teacherData);
            return $teacher;
        });
    }

    /**
     * get teacher details
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $teacher = Teacher::with(['documents'])->find($id);
        $settings = Setting::query()->where('user_id',$teacher->id)->first();
        $teacher['settings'] = $settings;
        $block_teacher = Blacklist::query()->where('teacher_id',$teacher->id)->first();
        $block = !($block_teacher == null);
        $teacher['is_blocked'] = $block;
        return $teacher;
    }

    public function update_verify(array $data,Teacher $teacher){
        return DB::transaction(function () use ($data,$teacher){
            if ($teacher->update([
                'is_verified'=>$data['is_verified']
            ])){
                return $teacher;
            }
        });
        throw new GeneralException('error');
    }
}
