<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'chat_notification'=>1,
            'agenda_notification'=>1,
            'related_offer_notification'=>1,
            'application_notification'=>1,
            'user_id'=>1
        ]);
    }
}
