<?php

namespace App\Models\Traits\RoleTraits;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

trait RoleMethod
{
    public static function getRole($name)
    {
        return DB::table('roles')->where('name', $name)->pluck('id')->first();
    }

    public static function getPermissions($roleId)
    {
        return Role::find($roleId)->permissions()->get();
    }
}
