<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\Map\DistanceRequest;
use App\Http\Requests\api\TeacherAvailability\CreateAvailableDaysRequest;
use App\Http\Requests\api\TeacherAvailability\GetDaysRequest;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Teacher;
use App\Models\TeacherAvailableTime;
use App\Models\TeacherSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\DateTime;

class TeacherAvailabilityController extends Controller
{
    public function store(CreateAvailableDaysRequest $request)
    {
        $array = [];
        foreach ($request->all() as $data) {
            foreach ($data['day'] as $key => $value) {
                $days = [];
                $startDate = new DateTime($data['from_date']);
                $endDate = new DateTime($data['to_date']);
                $numberOfDay = $this->numOfDay($value);
                while ($startDate <= $endDate) {
                    if ($startDate->format('w') == $numberOfDay) {
                        $days[] = $startDate->format('Y-m-d');
                    }
                    $startDate->modify('+1 day');
                }
                $array[$key]['days'] = $days;
                $array[$key]['offer_id'] = $data['offer_id'];
            }
        }
        foreach ($array as $data) {
            foreach ($data['days'] as $day) {
                $schedules[] = TeacherSchedule::create([
                    'day' => Carbon::createFromFormat('Y-m-d', $day)->format('l'),
                    'date' => $day,
                    'teacher_id' => auth()->user()->id,
                    'offer_id'=>$data['offer_id']
                ]);
            }
        }
        foreach ($schedules as $schedule) {
            $start_time = Carbon::parse('06:00')->format('H:i');
            $end_time = Carbon::parse('23:00')->format('H:i');
            while ($start_time < $end_time) {
                $times[] = TeacherAvailableTime::create([
                    'time' => $start_time,
                    'schedule_id' => $schedule->id,
                ]);
                $start_time = Carbon::parse($start_time)->addHour()->format('H:i');
            }
            DB::table('teacher_available_times')->insert([
                ['time' => $start_time, 'schedule_id' => $schedule->id],
                ['time' => Carbon::parse($start_time)->addHour()->format('H:i'), 'schedule_id' => $schedule->id]
            ]);

        }

        return success_response($schedules);
    }

    public function numOfDay($day)
    {
        $week = [
            'sun' => 0,
            'mon' => 1,
            'tue' => 2,
            'wed' => 3,
            'thu' => 4,
            'fri' => 5,
            'sat' => 6,
        ];

        return $week[$day];
    }

    public function getAvailableTimes()
    {
        $user_id = $_GET['user_id'];
        $date = $_GET['date'];
        $availableDay = TeacherSchedule::query()->where([
            ['teacher_id', $user_id],
            ['date', 'like', '%'.$date.'%'],
        ])->first();
        if (! $availableDay) {
            return not_found_response('No hay horarios disponibles');
        }
        $availableTimes = TeacherAvailableTime::query()->where('schedule_id', $availableDay->id)->get();

        return success_response($availableTimes);
    }

    public function getMapTeachers(DistanceRequest $request)
    {
        $lat = $request->lat;
        $lng = $request->lng;
        $material_id = $request->material_id;
        if (isset($material_id)) {
            $teachers = Teacher::query()
                ->where('is_active', 1)
                ->whereHas('materials', function ($q) use ($material_id) {
                    $q->where('material_id', $material_id);
                })->get();
        } else {
            $teachers = Teacher::query()
                ->where('is_active', 1)->get();
        }
        $get_teachers = [];
        foreach ($teachers as $teacher) {
            $distance = $this->getDistanceBetweenPointsNew($lat, $lng, $teacher->lat, $teacher->lng);
            if ($distance <= 40) {
                $get_teachers[] = $teacher;
            }
        }

        return response()->json([
            'status' => 1,
            'message' => 'success',
            'date' => $get_teachers,
        ], 200);
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

    public function showAvailableTime($id)
    {
        //Get Available time
        $availableTime = TeacherAvailableTime::query()->where('id', $id)->first();
        //Response
        return success_response($availableTime);
    }

    public function editAvailableTime($id, Request $request)
    {
        //Get Available time
        $availableTime = TeacherAvailableTime::query()->where('id', $id)->first();
        $offer_id = $availableTime->schedule->offer_id;
        $old_time = $availableTime->time;
        //Edit
        $availableTime->update([
            'details' => $request->details ?? $availableTime->details,
            'is_available' => $request->is_available ?? $availableTime->is_available,
            'time' => $request->time ?? $availableTime->time,
        ]);
        //Response
        $message = 'Los detalles de la clase cambiaron en ese momento:'.$old_time.'
        Nuevos detalles:
        los detalles:'.$availableTime->details.'
        disponible:'.$availableTime->is_available.'
        el tiempo:'.$availableTime->time;
        $user = auth()->user();
        $offer = Offer::query()->where('id',$offer_id)->first();
        if($offer->customer_id == null){
            $user_id = $offer->admin_id;
        }else{
            $user_id = $offer->customer_id;
        }
        $reciever = User::query()->where('id', $user_id)->first();
        send_message_notification($reciever, "Un cambio en la agenda", $message);
        Notification::create([
            'user_id' => $reciever->id,
            'title'=>'Un cambio en la agenda',
            'content' => $message,
        ]);

        return success_response($availableTime);
    }

    public function getDaysBetweenTwoDates(GetDaysRequest $request)
    {
        $startDate = new DateTime($request->from_date);
        $endDate = new DateTime($request->to_date);
        while ($startDate <= $endDate) {
            $day = $startDate->format('Y-m-d');
            $availableDay = TeacherSchedule::query()->where('date', $day)
                ->whereHas('availableTimes', function ($query) {
                    $query->where('is_available', 1);
                })->with('availableTimes')->first();
            if ($availableDay) {
                $days[] = $availableDay;
            }
            $startDate->modify('+1 day');
        }

        return success_response($days);
    }
}
