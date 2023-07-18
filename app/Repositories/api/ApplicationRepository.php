<?php

namespace App\Repositories\api;

use App\Exceptions\GeneralException;
use App\Models\Application;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Setting;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class ApplicationRepository extends BaseRepository
{
    public function model()
    {
        return Application::class;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            //get user
            $user = auth()->user();
            //check if teacher exist
            $teacher = Teacher::where('user_id', $user->id)->first();
            if (! $teacher) {
                throw new GeneralException('No hay profesor/a');
            }
            //check if offer is exist
            $offer = Offer::find($data['offer_id']);
            if (! $offer) {
                throw new GeneralException('no hay oferta');
            }
            //create applcation
            $application = parent::create([
                'offer_id' => $data['offer_id'],
                'teacher_id' => $teacher->id,
            ]);

            return $application;
        });
        throw new GeneralException(__('error'));
    }

    public function status(array $data)
    {
        $application = Application::find($data['application_id']);
        if (! $application) {
            throw new GeneralException('no se encontró la aplicación.');
        }
        $application->status = $data['status'];
        $application->save();
        $teacher = $application->teacher;
        $user = User::query()->where('id',$teacher->user_id)->first();
        $settings = Setting::query()->where('user_id',$user->id)->first();
        if ($settings->application_notification){
            $title = "Cambiar el estado del pedido";
            $message="El estado de su pedido ha cambiado a".$data['status'];
            $link ="/api/application/".$application->id;
            send_message_notification($user, $title, $message);
            Notification::create([
                'user_id' => $user->id,
                'content' => $message,
                'title'=>$title,
                'link'=>$link
            ]);
        }
        return $application;
    }
}
