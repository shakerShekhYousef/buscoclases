<?php

namespace App\Models\Traits\RoleTraits;

use App\Models\Permission;
use App\Models\User;

trait RoleRelationship
{
    public function permissions()
    {
        return $this
            ->belongsToMany(Permission::class, 'role_permissions');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
