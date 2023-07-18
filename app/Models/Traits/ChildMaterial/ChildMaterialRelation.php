<?php

namespace App\Models\Traits\ChildMaterial;

use App\Models\SubMaterial;
use App\Models\Teacher;

trait ChildMaterialRelation
{
    public function sub_material()
    {
        return $this->belongsTo(SubMaterial::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_child_materials');
    }
}
