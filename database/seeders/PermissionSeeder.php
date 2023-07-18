<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('permissions')->truncate();
        DB::table('permissions')->upsert([
            [
                'name' => 'Can view Teachers',
                'code' => 'view_teacher',
                'group' => 'Teachers',
            ],
            [
                'name' => 'Can create Teachers',
                'code' => 'create_teacher',
                'group' => 'Teachers',
            ],
            [
                'name' => 'Can update Teachers',
                'code' => 'update_teacher',
                'group' => 'Teachers',
            ],
            [
                'name' => 'Can delete Teachers',
                'code' => 'delete_teacher',
                'group' => 'Teachers',
            ],
        ], ['code']);
    }
}
