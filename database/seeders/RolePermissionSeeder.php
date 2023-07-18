<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('role_permissions')->truncate();
        $permissoins = Permission::all();
        $data = [];
        foreach ($permissoins as $permission) {
            array_push($data, ['role_id' => 1, 'permission_id' => $permission->id]);
        }
        DB::table('role_permissions')->insert($data);
    }
}
