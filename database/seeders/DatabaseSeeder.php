<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MaterialSeeder::class);
        $this->call(SubMaterialSeeder::class);
        $this->call(ChildMaterialSeeder::class);
        $this->call(NationalitySeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(LevelTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(SubjectListTableSeeder::class);
        Artisan::call('passport:install');
    }
}
