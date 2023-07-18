<?php

namespace App\Models\Traits\UserTraits;

use App\Models\Group;
use App\Models\Notification;
use App\Models\Role;
use App\Models\Setting;

trait UserRelationship
{
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_groups');
    }

    public function setting(){
        return $this->hasOne(Setting::class);
    }
}
