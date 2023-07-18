<?php

namespace App\Models\Traits\NotificationTraits;

use App\Models\User;

trait NotificationRelationship
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
