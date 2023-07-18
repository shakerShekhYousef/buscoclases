<?php

namespace App\Models\Traits\SettingTraits;

use App\Models\User;

trait SettingRelationship
{
    public function user(){
        return $this->belongsTo(User::class);
    }
}
