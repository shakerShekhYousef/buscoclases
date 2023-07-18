<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materials')->insert([
            ['name' => 'Niñera'],
            ['name' => 'Campamentos y fiestas'],
            ['name' => 'Idiomas'],
            ['name' => 'Refuerzo escolar'],
            ['name' => 'Deporte'],
            ['name' => 'Danza'],
            ['name' => 'Artes escénicas'],
            ['name' => 'Ajedrez'],
            ['name' => 'Cocina'],
            ['name' => 'Psicología'],
            ['name' => 'Artes plásticas'],
            ['name' => 'Música'],
            ['name' => 'Informática'],
            ['name' => 'Robótica '],
            ['name' => 'Fotografía y video'],
            ['name' => 'Speakers'],
            ['name' => 'Oposiciones'],
            ['name' => 'Certificado de profesionalidad'],
            ['name' => 'Educación Infantil'],
        ]);
    }
}
