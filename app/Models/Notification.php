<?php

namespace App\Models;

use App\Models\Traits\NotificationTraits\NotificationRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use NotificationRelationship,HasFactory;

    protected $guarded = [];
}
