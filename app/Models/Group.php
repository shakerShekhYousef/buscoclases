<?php

namespace App\Models;

use App\Models\Traits\GroupTrait\GroupMethod;
use App\Models\Traits\GroupTrait\GroupRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory,GroupRelationship,GroupMethod;

    protected $guarded = [];
}
