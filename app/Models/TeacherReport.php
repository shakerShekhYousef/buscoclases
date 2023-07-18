<?php

namespace App\Models;

use App\Models\Traits\TeacherReportTraits\TeacherReportMethod;
use App\Models\Traits\TeacherReportTraits\TeacherReportRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherReport extends Model
{
    use TeacherReportRelationship,TeacherReportMethod,HasFactory;

    protected $guarded = [];
}
