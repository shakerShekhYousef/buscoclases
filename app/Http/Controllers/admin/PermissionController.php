<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * get permissions list
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $permissions = Permission::all();

        return success_response($permissions);
    }
}
