<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->insert([
            ['level' => 'primario', 'material_id' => 4],
            ['level' => 'secundario', 'material_id' => 4],
            ['level' => 'escuela secundaria', 'material_id' => 4],
            ['level' => 'Universidad', 'material_id' => 4],
            ['level' => 'básico', 'material_id' => 3],
            ['level' => 'intermedio', 'material_id' => 3],
            ['level' => 'avanzado', 'material_id' => 3],
            ['level' => 'nativo', 'material_id' => 3],
            ['level' => 'básico', 'material_id' => 5],
            ['level' => 'medio', 'material_id' => 5],
            ['level' => 'alto', 'material_id' => 5],
            ['level' => 'básico', 'material_id' => 6],
            ['level' => 'medio', 'material_id' => 6],
            ['level' => 'alto', 'material_id' => 6],
            ['level' => 'básico', 'material_id' => 11],
            ['level' => 'medio', 'material_id' => 11],
            ['level' => 'alto', 'material_id' => 11],
            ['level' => 'básico', 'material_id' => 8],
            ['level' => 'medio', 'material_id' => 8],
            ['level' => 'alto', 'material_id' => 8],
            ['level' => 'básico', 'material_id' => 9],
            ['level' => 'medio', 'material_id' => 9],
            ['level' => 'alto', 'material_id' => 9],
            ['level' => 'básico', 'material_id' => 12],
            ['level' => 'medio', 'material_id' => 12],
            ['level' => 'alto', 'material_id' => 12],
            ['level' => 'básico', 'material_id' => 13],
            ['level' => 'medio', 'material_id' => 13],
            ['level' => 'alto', 'material_id' => 13],
            ['level' => 'básico', 'material_id' => 14],
            ['level' => 'medio', 'material_id' => 14],
            ['level' => 'alto', 'material_id' => 14],
            ['level' => 'básico', 'material_id' => 15],
            ['level' => 'medio', 'material_id' => 15],
            ['level' => 'alto', 'material_id' => 15],
        ]);
    }
}
