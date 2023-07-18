<?php

namespace App\Models\Traits\TeacherAvailableTimeTraits;

use App\Models\TeacherSchedule;

trait TeacherAvailableTimeRelationship
{
    public function schedule()
    {
        return $this->belongsTo(TeacherSchedule::class, 'schedule_id', 'id');
    }
}
