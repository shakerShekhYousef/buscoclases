<?php

namespace App\Models;

use App\Models\Traits\TeacherTraits\TeacherRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use TeacherRelationship,HasFactory;

    protected $guarded = [];
}
