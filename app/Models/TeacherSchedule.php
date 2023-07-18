<?php

namespace App\Models;

use App\Models\Traits\TeacherSchedule\TeacherScheduleRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSchedule extends Model
{
    use HasFactory,TeacherScheduleRelationship;

    protected $guarded = [];
}
