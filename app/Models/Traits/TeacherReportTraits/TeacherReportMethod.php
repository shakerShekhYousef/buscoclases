<?php

namespace App\Models\Traits\TeacherReportTraits;

trait TeacherReportMethod
{
    public function scopeBlacklist($query, $teacher_id = null)
    {
        if ($teacher_id != null) {
            return $query->where('teacher_id', $teacher_id);
        }

        return $query;
    }
}
