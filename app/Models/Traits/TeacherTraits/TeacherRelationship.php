<?php

namespace App\Models\Traits\TeacherTraits;

use App\Models\Application;
use App\Models\ChildMaterial;
use App\Models\Document;
use App\Models\Material;
use App\Models\SubMaterial;
use App\Models\TeacherAvailableTime;
use App\Models\TeacherList;
use App\Models\TeacherSchedule;
use App\Models\TeacherSubMaterial;

trait TeacherRelationship
{
    public function documents()
    {
        return $this->hasOne(Document::class);
    }

    public function comments()
    {
        return $this->hasMany(TeacherReport::class, 'teacher_id', 'id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function schedules()
    {
        return $this->hasMany(TeacherSchedule::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'teacher_materials');
    }

    public function sub_materials()
    {
        return $this->belongsToMany(SubMaterial::class, 'teacher_sub_materials');
    }

    public function child_materials()
    {
        return $this->belongsToMany(ChildMaterial::class, 'teacher_child_materials');
    }

    public function scheduleTimes()
    {
        return $this->hasManyThrough(TeacherAvailableTime::class, TeacherSchedule::class);
    }
    public function teacher_lists(){
        return $this->hasMany(TeacherList::class);
    }
    public function levels(){
        $this->hasManyThrough(TeacherSubMaterial::class,SubMaterial::class);
    }
}
