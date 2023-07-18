<?php

namespace App\Repositories\api;

use App\Exceptions\GeneralException;
use App\Models\Application;
use App\Models\Document;
use App\Models\Role;
use App\Models\SubjectList;
use App\Models\Teacher;
use App\Models\TeacherList;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class TeacherRepository extends BaseRepository
{
    public function model()
    {
        return Teacher::class;
    }

    public function create(array $data)
    {
        $user = auth()->user();
        $check = Teacher::where('user_id', $user->id)->first();
        if ($check != null) {
            return response()->json(['status' => 0, 'message' => 'already existed'], 403);
        }
        $user->update([
            'role_id' => Role::getRole('Teacher'),
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
        ];

        $teacher = Teacher::create($teacherData);
        $user->update(['role_id' => Role::getRole('Teacher')]);
//        if ($data['schedules'] != null) {
//            foreach ($data['schedules'] as $schedule) {
//                //$schedule = json_decode($schedule, true);
//                DB::table('teacher_schedules')->insert([
//                    'date' => isset($schedule['date']) ? $schedule['date'] : null,
//                    'am' => isset($schedule['am']) ? $schedule['am'] : 0,
//                    'pm' => isset($schedule['pm']) ? $schedule['pm'] : 0,
//                    'teacher_id' => $teacher->id,
//                ]);
//            }
//        }

        return $teacher;
    }

    public function upload_document(array $data)
    {
        return DB::transaction(function () use ($data) {
            //get user
            $user = auth()->user();
            //check if a teacher existed
            $teacher = Teacher::where('user_id', $user->id)->first();
            if (! $teacher) {
                throw new GeneralException('No hay profesor/a');
            }

            return Document::create([
                'title' => $data['title'],
                'file' => $this->UploadFile($data['file'], $teacher->id),
                'teacher_id' => $teacher->id,
            ]);
        });
    }

    public function get_teacher_applications(array $data)
    {
        return Application::query()->where('teacher_id', auth()->user()->id)->get();
    }

    // Upload image function
    public function UploadFile($file, $path)
    {
        //get file name with extention
        $filenameWithExt = $file->getClientOriginalName();
        //get just file name
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //GET EXTENTION
        $extention = $file->getClientOriginalExtension();
        //file name to store
        $fileNameToStore = '/files/teachers/'.$path.'/'.$filename.'_'.time().'.'.$extention;
        //upload image
        $path = $file->storeAs('public/', $fileNameToStore);

        return $fileNameToStore;
    }

    public function uploadedFiles($teacher_id)
    {
        $files = Document::where('teacher_id', $teacher_id)->get();

        return $files;
    }
}
