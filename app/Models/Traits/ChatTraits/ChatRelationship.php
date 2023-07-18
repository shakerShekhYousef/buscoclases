<?php

namespace App\Models\Traits\ChatTraits;

use App\Models\Customer;
use App\Models\Message;
use App\Models\Teacher;
use App\Models\User;

trait ChatRelationship
{
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin', 'id');
    }
}
