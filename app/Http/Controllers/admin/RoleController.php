<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return success_response($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
        ]);
        if ($validator->fails()) {
            return error_response($validator->errors()->first());
        }
        $role = Role::create(['name' => $request['name']]);
        if ($role) {
            $permissions = [];
            foreach ($request['permissions'] as $item) {
                array_push($permissions, ['role_id' => $role->id, 'permission_id' => $item]);
            }
            RolePermission::insert($permissions);

            return success_response($role);
        }

        return server_error_response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::with(['permissions'])->find($id);

        return success_response($role->permissions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if ($role == null) {
            return not_found_response('role not found');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return error_response($validator->errors()->first());
        }
        if ($request['name'] != null) {
            $role->name = $request['name'];
            $role->save();
        }

        $permissions = [];
        foreach ($request['permissions'] as $item) {
            array_push($permissions, ['role_id' => $role->id, 'permission_id' => $item]);
        }
        RolePermission::where('role_id', $id)->delete();
        if (! empty($permissions)) {
            RolePermission::insert($permissions);
        }

        return success_response($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
