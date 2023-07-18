<?php

namespace App\Models;

use App\Models\Traits\RoleTraits\RoleMethod;
use App\Models\Traits\RoleTraits\RoleRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use RoleRelationship,RoleMethod,HasFactory;

    protected $guarded = [];
}
