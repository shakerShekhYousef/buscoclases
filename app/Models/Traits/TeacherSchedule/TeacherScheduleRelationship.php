<?php

namespace App\Models\Traits\TeacherSchedule;

use App\Models\Offer;
use App\Models\Teacher;
use App\Models\TeacherAvailableTime;

trait TeacherScheduleRelationship
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function availableTimes()
    {
        return $this->hasMany(TeacherAvailableTime::class, 'schedule_id', 'id');
    }

    public function offer(){
        return $this->belongsTo(Offer::class);
    }
}
