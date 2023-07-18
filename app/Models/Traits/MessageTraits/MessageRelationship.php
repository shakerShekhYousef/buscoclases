<?php

namespace App\Models\Traits\MessageTraits;

use App\Models\Chat;
use App\Models\User;

trait MessageRelationship
{
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
