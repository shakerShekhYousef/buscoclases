<?php

namespace App\Models;

use App\Models\Traits\PermissionTraits\PermissionRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use PermissionRelationship,HasFactory;

    protected $guraded = [];
}
