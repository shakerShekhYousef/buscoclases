<?php

namespace App\Models;

use App\Models\Traits\UserGroupTrait\UserGroupMethod;
use App\Models\Traits\UserGroupTrait\UserGroupRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory,UserGroupRelationship,UserGroupMethod;

    protected $guarded = [];
}
