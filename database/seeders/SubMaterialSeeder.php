<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sub_materials')->insert([
            ['name' => 'Animador', 'material_id' => 2],
            ['name' => 'Monitor', 'material_id' => 2],
            ['name' => 'Coordinador', 'material_id' => 2],
            ['name' => 'Director', 'material_id' => 2],
            ['name' => 'Pintacaras', 'material_id' => 2],
            ['name' => 'Cuentacuentos', 'material_id' => 2],

            ['name' => 'Inglés', 'material_id' => 3],
            ['name' => 'Francés', 'material_id' => 3],
            ['name' => 'Alemán', 'material_id' => 3],
            ['name' => 'Chino', 'material_id' => 3],
            ['name' => 'Italiano', 'material_id' => 3],
            ['name' => 'Español', 'material_id' => 3],
            ['name' => 'Turco', 'material_id' => 3],
            ['name' => 'Hebreo', 'material_id' => 3],
            ['name' => 'Coreano', 'material_id' => 3],
            ['name' => 'Japonés', 'material_id' => 3],
            ['name' => 'Lengua de signos', 'material_id' => 3],
            ['name' => 'Gallego', 'material_id' => 3],
            ['name' => 'Catalán', 'material_id' => 3],
            ['name' => 'Vasco', 'material_id' => 3],
            ['name' => 'Valenciano', 'material_id' => 3],
            ['name' => 'Portugués', 'material_id' => 3],
            ['name' => 'Árabe', 'material_id' => 3],
            ['name' => 'Latín', 'material_id' => 3],
            ['name' => 'Griego', 'material_id' => 3],
            ['name' => 'Polaco', 'material_id' => 3],
            ['name' => 'Rumano', 'material_id' => 3],
            ['name' => 'Búlgaro', 'material_id' => 3],

            ['name' => 'Matemáticas', 'material_id' => 4],
            ['name' => 'Lengua', 'material_id' => 4],
            ['name' => 'Física y química', 'material_id' => 4],
            ['name' => 'Tecnología', 'material_id' => 4],
            ['name' => 'Dibujo', 'material_id' => 4],
            ['name' => 'Biología', 'material_id' => 4],
            ['name' => 'Geografía', 'material_id' => 4],
            ['name' => 'Filosofía', 'material_id' => 4],
            ['name' => 'Economía', 'material_id' => 4],
            ['name' => 'Música', 'material_id' => 4],
            ['name' => 'Historia del arte', 'material_id' => 4],
            ['name' => 'Derecho', 'material_id' => 4],
            ['name' => 'Administración y economía', 'material_id' => 4],
            ['name' => 'Contabilidad', 'material_id' => 4],
            ['name' => 'Ingeniería', 'material_id' => 4],
            ['name' => 'Diseño gráfico', 'material_id' => 4],


            ['name' => 'Fútbol', 'material_id' => 5],
            ['name' => 'Baloncesto', 'material_id' => 5],
            ['name' => 'Voleibol', 'material_id' => 5],
            ['name' => 'Pinpon', 'material_id' => 5],
            ['name' => 'Rugby', 'material_id' => 5],
            ['name' => 'Tenis', 'material_id' => 5],
            ['name' => 'Pádel', 'material_id' => 5],
            ['name' => 'Socorrista', 'material_id' => 5],
            ['name' => 'Waterpolo', 'material_id' => 5],
            ['name' => 'Entrenador personal', 'material_id' => 5],
            ['name' => 'Badminton', 'material_id' => 5],
            ['name' => 'Patinaje en línea', 'material_id' => 5],
            ['name' => 'Patinaje sobre ruedas', 'material_id' => 5],
            ['name' => 'Gimnasia rítmica', 'material_id' => 5],
            ['name' => 'Atletismo', 'material_id' => 5],
            ['name' => 'Boxeo', 'material_id' => 5],
            ['name' => 'Yoga', 'material_id' => 5],
            ['name' => 'Pilates', 'material_id' => 5],
            ['name' => 'Gimnasia para mayores', 'material_id' => 5],
            ['name' => 'Aerobic', 'material_id' => 5],
            ['name' => 'Zumba', 'material_id' => 5],
            ['name' => 'Natación', 'material_id' => 5],
            ['name' => 'Balonmano', 'material_id' => 5],
            ['name' => 'Judo', 'material_id' => 5],
            ['name' => 'Artes marciales', 'material_id' => 5],
            ['name' => 'Karate', 'material_id' => 5],
            ['name' => 'Hípica', 'material_id' => 5],



            ['name' => 'Baile latinos', 'material_id' => 6],
            ['name' => 'Danza oriental', 'material_id' => 6],
            ['name' => 'Danza española', 'material_id' => 6],
            ['name' => 'Danza moderna', 'material_id' => 6],
            ['name' => 'Danza clásica', 'material_id' => 6],
            ['name' => 'Pole dance', 'material_id' => 6],
            ['name' => 'Danza aérea', 'material_id' => 6],
            ['name' => 'Aerobic', 'material_id' => 6],
            ['name' => 'Zumba', 'material_id' => 6],
            ['name' => 'Bailes de salón', 'material_id' => 6],
            ['name' => 'Kizomba', 'material_id' => 6],
            ['name' => 'Bailes regionales', 'material_id' => 6],

            ['name' => 'Teatro ', 'material_id' => 7],
            ['name' => 'Clown', 'material_id' => 7],
            ['name' => 'Oratoria', 'material_id' => 7],
            ['name' => 'Circo', 'material_id' => 7],

            ['name' => 'Inteligencia emocional', 'material_id' => 10],
            ['name' => 'Musicoterapeuta', 'material_id' => 10],
            ['name' => 'Logopeda', 'material_id' => 10],
            ['name' => 'TDAH', 'material_id' => 10],
            ['name' => 'TDA', 'material_id' => 10],
            ['name' => 'Dislexia', 'material_id' => 10],
            ['name' => 'Arteterapia', 'material_id' => 10],
            ['name' => 'Taller para padres', 'material_id' => 10],
            ['name' => 'Taller de memoria', 'material_id' => 10],

            ['name' => 'Dibujo y pintura', 'material_id' => 11],
            ['name' => 'Manga', 'material_id' => 11],
            ['name' => 'Cerámica y escultura', 'material_id' => 11],
            ['name' => 'Restauración de muebles', 'material_id' => 11],
            ['name' => 'Escayola', 'material_id' => 11],
            ['name' => 'Arte urbano', 'material_id' => 11],
            ['name' => 'Dibujo técnico', 'material_id' => 11],
            ['name' => 'Bolillos', 'material_id' => 11],
            ['name' => 'Manualidades', 'material_id' => 11],
            ['name' => 'Corte y confección', 'material_id' => 11],
            ['name' => 'Patronaje', 'material_id' => 11],
            ['name' => 'Pachwork', 'material_id' => 11],

            ['name' => 'Solfeo', 'material_id' => 12],
            ['name' => 'Flauta', 'material_id' => 12],
            ['name' => 'Guitarra', 'material_id' => 12],
            ['name' => 'Piano', 'material_id' => 12],
            ['name' => 'Arpa', 'material_id' => 12],
            ['name' => 'Violín', 'material_id' => 12],
            ['name' => 'Viola', 'material_id' => 12],
            ['name' => 'Violonchelo', 'material_id' => 12],
            ['name' => 'Percusión', 'material_id' => 12],
            ['name' => 'Saxofón', 'material_id' => 12],
            ['name' => 'Clarinete', 'material_id' => 12],
            ['name' => 'Oboe', 'material_id' => 12],
            ['name' => 'Acordeón', 'material_id' => 12],
            ['name' => 'Trompeta', 'material_id' => 12],
            ['name' => 'Batería', 'material_id' => 12],
            ['name' => 'Canto', 'material_id' => 12],

            ['name' => 'Mecanografía', 'material_id' => 13],
            ['name' => 'Ofimática', 'material_id' => 13],
            ['name' => 'Diseño gráfico', 'material_id' => 13],
            ['name' => 'Ecommerce', 'material_id' => 13],
            ['name' => 'Impresión 3D', 'material_id' => 13],

            ['name' => 'Igualdad de género', 'material_id' => 16],
            ['name' => 'Violencia y bullying', 'material_id' => 16],
            ['name' => 'Uso de tecnologías e internet', 'material_id' => 16],
            ['name' => 'Medioambiente', 'material_id' => 16],
            ['name' => 'Educación sexual', 'material_id' => 16],
            ['name' => 'La pubertad', 'material_id' => 16],
            ['name' => 'Educación Vial', 'material_id' => 16],
            ['name' => 'Valores e inteligencia emocional', 'material_id' => 16],

            ['name' => 'Educador infantil', 'material_id' => 19],
            ['name' => 'Psicomotricidad', 'material_id' => 19],
            ['name' => 'Coordinador', 'material_id' => 19],
            ['name' => 'Director', 'material_id' => 19],
            ['name' => 'Terapia infantil con música', 'material_id' => 19],
        ]);
    }
}
