<?php

namespace App\Models\Traits\CustomerTraits;

use App\Models\Offer;
use App\Models\User;

trait CustomerRelationship
{
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(TeacherReport::class, 'customer_id', 'id');
    }
}
