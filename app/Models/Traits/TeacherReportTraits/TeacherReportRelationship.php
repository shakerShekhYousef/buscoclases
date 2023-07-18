<?php

namespace App\Models\Traits\TeacherReportTraits;

use App\Models\Customer;
use App\Models\Teacher;

trait TeacherReportRelationship
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
