<?php

namespace App\Models\Traits\GroupMessageTrait;

use App\Models\Group;
use App\Models\User;

trait GroupMessageRelationship
{
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
