<?php

namespace App\Models\Traits\Material;

use App\Models\Level;
use App\Models\SubMaterial;
use App\Models\Teacher;

trait MaterialRelationTrait
{
    public function sub_materials()
    {
        return $this->hasMany(SubMaterial::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_materials');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function levels()
    {
        return $this->hasMany(Level::class);
    }
}
