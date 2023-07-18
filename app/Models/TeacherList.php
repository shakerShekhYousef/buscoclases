<?php

namespace App\Models;

use App\Models\Traits\TeacherListTraits\TeacherListRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherList extends Model
{
    use HasFactory,TeacherListRelationship;

    protected $guarded = [];
}
