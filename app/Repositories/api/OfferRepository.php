<?php

namespace App\Repositories\api;

use App\Exceptions\GeneralException;
use App\Http\Requests\api\Map\DistanceRequest;
use App\Models\Application;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Setting;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OfferRepository extends BaseRepository
{
    public function model()
    {
        return Offer::class;
    }

    public function create(array $data)
    {
        //create a new offer
        return DB::transaction(function () use ($data) {
            //get the customer id
            $customer = Customer::where('user_id', auth()->user()->id)->first();
            if (! $customer) {
                throw new GeneralException('Este no es un cliente.');
            }
            //create
            $offer = parent::create([
                'customer_id' => $customer->id,
                'material_id' => $data['material_id'],
                'position_title' => $data['position_title'],
                'description' => $data['description'],
                'lat' => $data['lat'],
                'lng' => $data['lng'],
                'range' => $data['range'],
                'job_type' => $data['job_type'],
                'working_hours' => $data['working_hours'],
                'start_date' => $data['start_date'],
                'end_date'=>$data['end_date'] ?? $this->add_days($data['start_date']),
                'immediate_incorporation' => $data['immediate_incorporation'],
                'salary' => $data['salary'],
                'full_salary' => $data['full_salary'],
                'level' => $data['level'],
                'require_experience' => $data['require_experience'],
                'prepare_official_exam' => $data['prepare_official_exam'],
            ]);
            $teachers = $this->getMapTeachers($data['lat'],$data['lng']);
            foreach ($teachers as $teacher){
                $user_id = $teacher['user_id'];
                $user =User::query()->where('id',$user_id)->first();
                $settings = Setting::query()->where('user_id',$user->id)->first();
                if ($settings->related_offer_notification){
                    $title = "Nueva oferta";
                    $message="Se ha publicado una nueva oferta cerca de ti";
                    $link ="/api/offer/".$offer->id;
                    send_message_notification($user, $title, $message);
                    Notification::create([
                        'user_id' => $user->id,
                        'content' => $message,
                        'title'=>$title,
                        'link'=>$link
                    ]);
                }
            }
            if ($offer) {
                return $offer;
            }
            throw new GeneralException(__('error'));
        });
    }

    public function update(Offer $offer, array $data)
    {
        //create a new offer
        return DB::transaction(function () use ($offer, $data) {
            if ($offer->update([
                'position_title' => $data['position_title'] !== null ? $data['position_title'] : $offer->position_title,
                'description' => $data['description'] !== null ? $data['description'] : $offer->description,
                'lat' => $data['lat'] !== null ? $data['lat'] : $offer->lat,
                'lng' => $data['lng'] !== null ? $data['lng'] : $offer->lng,
                'range' => $data['range'] !== null ? $data['range'] : $offer->range,
                'material_id' => $data['material_id'] !== null ? $data['material_id'] : $offer->material_id,
                'job_type' => $data['job_type'] !== null ? $data['job_type'] : $offer->job_type,
                'working_hours' => $data['working_hours'] !== null ? $data['working_hours'] : $offer->working_hours,
                'start_date' => $data['start_date'] !== null ? $data['start_date'] : $offer->start_date,
                'end_date'=>$data['end_date'] ?? $this->add_days($data['start_date']),
                'immediate_incorporation' => $data['immediate_incorporation'] !== null ? $data['immediate_incorporation'] : $offer->immediate_incorporation,
                'salary' => $data['salary'] !== null ? $data['salary'] : $offer->salary,
                'full_salary' => $data['full_salary'] !== null ? $data['full_salary'] : $offer->full_salary,
                'subject' => $data['subject'] !== null ? $data['subject'] : $offer->subject,
                'level' => $data['level'] !== null ? $data['level'] : $offer->level,
                'require_experience' => $data['require_experience'] !== null ? $data['require_experience'] : $offer->require_experience,
                'prepare_official_exam' => $data['prepare_official_exam'] !== null ? $data['prepare_official_exam'] : $offer->prepare_official_exam,

            ])) {
                return $offer;
            }
            throw new GeneralException(__('error'));
        });
    }

    public function check_application_for_offer(array $data)
    {
        $applications = Application::query()->where([
            ['teacher_id', auth()->user()->id],
            ['offer_id', $data['offer_id']],
        ])->count();

        return $applications > 0 ?
            success_response(['applied' => true])
            : success_response(['applied' => false]);
    }

    public function getMapTeachers($lat,$lng)
    {
        $teachers = Teacher::query()
            ->where('is_active', 1)->get();
        $get_teachers = [];
        foreach ($teachers as $teacher) {
            $distance = $this->getDistanceBetweenPointsNew($lat, $lng, $teacher->lat, $teacher->lng);
            if ($distance <= 40) {
                $get_teachers[] = $teacher;
            }
        }

        return $get_teachers;
    }

    public function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'kilometers')
    {
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        switch ($unit) {
            case 'miles':
                break;
            case 'kilometers':
                $distance = $distance * 1.609344;
        }

        return round($distance, 2);
    }

    public function add_days($start_date){
        $date = Carbon::createFromFormat('Y-m-d', $start_date);
        $daysToAdd = 5;
        return $date->addDays($daysToAdd);
    }
}
