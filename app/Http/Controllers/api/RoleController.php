<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Role;

class RoleController extends Controller
{
    public function get_role_permissions()
    {
        $role_id = $_GET['role_id'];

        return success_response(['role' => Role::findOrFail($role_id), 'permissions' => Role::getPermissions($role_id)]);
    }
}
