<?php

namespace App\Models\Traits\SubMaterial;

use App\Models\ChildMaterial;
use App\Models\Level;
use App\Models\Material;
use App\Models\Teacher;

trait SubMaterialRelation
{
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function child_materials()
    {
        return $this->hasMany(ChildMaterial::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_sub_materials');
    }

    public function levels()
    {
        return $this->hasMany(Level::class);
    }
}
