<?php

namespace App\Models;

use App\Models\Traits\TeacherMaterial\TeacherMaterialRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherMaterial extends Model
{
    use HasFactory, TeacherMaterialRelation;

    protected $guarded = [];
}
