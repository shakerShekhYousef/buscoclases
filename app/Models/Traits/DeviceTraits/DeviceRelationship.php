<?php

namespace App\Models\Traits\DeviceTraits;

use App\Models\User;

trait DeviceRelationship
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
