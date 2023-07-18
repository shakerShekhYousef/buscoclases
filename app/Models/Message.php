<?php

namespace App\Models;

use App\Models\Traits\MessageTraits\MessageRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use MessageRelationship,HasFactory;

    protected $guarded = [];
}
