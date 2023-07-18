<?php

namespace App\Models;

use App\Models\Traits\TeacherAvailableTimeTraits\TeacherAvailableTimeMethod;
use App\Models\Traits\TeacherAvailableTimeTraits\TeacherAvailableTimeRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAvailableTime extends Model
{
    use HasFactory,TeacherAvailableTimeRelationship,TeacherAvailableTimeMethod;

    protected $guarded = [];
}
