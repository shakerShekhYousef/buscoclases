<?php

namespace App\Models\Traits\RolePermissionTrait;

use App\Models\Permission;
use App\Models\Role;

trait RolePermissionMethod
{
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
