<?php

namespace App\Models\Traits\TeacherChildMaterial;

use App\Models\ChildMaterial;
use App\Models\Teacher;

trait TeacherChildMaterialRelation
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function child_material()
    {
        return $this->belongsTo(ChildMaterial::class);
    }
}
