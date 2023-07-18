<?php

namespace App\Models\Traits\GroupTrait;

use App\Models\User;

trait GroupRelationship
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_groups');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }
}
