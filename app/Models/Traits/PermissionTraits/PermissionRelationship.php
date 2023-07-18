<?php

namespace App\Models\Traits\PermissionTraits;

use App\Models\Role;

trait PermissionRelationship
{
    public function roles()
    {
        return $this
            ->belongsToMany(Role::class, 'role_permissions');
    }
}
