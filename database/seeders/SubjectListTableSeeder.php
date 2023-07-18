<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subject_lists')->insert([
            ['name'=>'Preparación de exámenes oficiales'],
            ['name'=>'Quiero trabajar con niños'],
            ['name'=>'Quiero trabajar con adultos'],
            ['name'=>'Quiero trabajar en empresas'],
            ['name'=>'Preparador de certificados de profesionalidad'],
            ['name'=>'Preparador de oposiciones'],
            ['name'=>'Carné de monitor/coordinador/director de ocio y tiempo libre'],
        ]);
    }
}
