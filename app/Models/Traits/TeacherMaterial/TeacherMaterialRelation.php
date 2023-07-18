<?php

namespace App\Models\Traits\TeacherMaterial;

use App\Models\Level;
use App\Models\Material;
use App\Models\Teacher;

trait TeacherMaterialRelation
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
