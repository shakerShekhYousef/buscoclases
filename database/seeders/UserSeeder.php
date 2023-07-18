<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'account_type' => 'admin',
                'role_id' => 1,
            ],
        ]);
    }
}
