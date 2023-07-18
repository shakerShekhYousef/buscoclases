<?php

namespace App\Models;

use App\Models\Traits\TeacherSubMaterial\TeacherSubMaterialRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubMaterial extends Model
{
    use HasFactory, TeacherSubMaterialRelation;

    protected $guarded = [];
}
