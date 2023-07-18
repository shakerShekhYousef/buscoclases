<?php

namespace App\Models;

use App\Models\Traits\LevelTraits\LevelMethod;
use App\Models\Traits\LevelTraits\LevelRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory, LevelRelationship, LevelMethod;
}
