<?php

namespace App\Models\Traits\OfferTraits;

use App\Models\Application;
use App\Models\Customer;
use App\Models\Material;
use App\Models\TeacherSchedule;
use App\Models\User;

trait OfferRelationship
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function admin(){
        return $this->hasMany(User::class,'id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function schedules(){
        return $this->hasMany(TeacherSchedule::class);
    }
}
