<?php

namespace App\Models;

use App\Models\Traits\ApplicationTraits\ApplicationRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use ApplicationRelationship,HasFactory;

    protected $guarded = [];
}
