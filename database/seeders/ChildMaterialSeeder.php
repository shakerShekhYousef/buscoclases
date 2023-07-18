<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChildMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('child_materials')->insert([
            ['name' => 'Letras', 'sub_material_id' => 30],
            ['name' => 'Ciencias', 'sub_material_id' => 30],

            ['name' => 'Letras', 'sub_material_id' => 31],
            ['name' => 'Ciencias', 'sub_material_id' => 31],

            ['name' => 'Derecho', 'sub_material_id' => 32],
            ['name' => 'Administración y economía', 'sub_material_id' => 32],
            ['name' => 'Contabilidad', 'sub_material_id' => 32],
            ['name' => 'Ingeniería', 'sub_material_id' => 32],
            ['name' => 'Diseño gráfico', 'sub_material_id' => 32],
        ]);
    }
}
