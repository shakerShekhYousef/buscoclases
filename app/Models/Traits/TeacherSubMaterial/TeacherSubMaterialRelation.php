<?php

namespace App\Models\Traits\TeacherSubMaterial;

use App\Models\Level;
use App\Models\SubMaterial;
use App\Models\Teacher;

trait TeacherSubMaterialRelation
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function sub_material()
    {
        return $this->belongsTo(SubMaterial::class);
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
