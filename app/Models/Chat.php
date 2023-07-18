<?php

namespace App\Models;

use App\Models\Traits\ChatTraits\ChatRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use ChatRelationship,HasFactory;

    protected $guarded = [];
}
