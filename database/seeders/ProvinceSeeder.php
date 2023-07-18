<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Province::insert([
            ['name' => 'Albacete'],
            ['name' => 'Alicante/Alacant'],
            ['name' => 'Almería'],
            ['name' => 'Araba/Álava'],
            ['name' => 'Asturias'],
            ['name' => 'Ávila'],
            ['name' => 'Badajoz'],
            ['name' => 'Balears, Illes'],
            ['name' => 'Barcelona'],
            ['name' => 'Bizkaia'],
            ['name' => 'Burgos'],
            ['name' => 'Cáceres'],
            ['name' => 'Cádiz'],
            ['name' => 'Cantabria'],
            ['name' => 'Castellón/Castelló'],
            ['name' => 'Ciudad Real'],
            ['name' => 'Córdoba'],
            ['name' => 'Coruña, A'],
            ['name' => 'Cuenca'],
            ['name' => 'Gipuzkoa'],
            ['name' => 'Girona'],
            ['name' => 'Granada'],
            ['name' => 'Guadalajara'],
            ['name' => 'Huelva'],
            ['name' => 'Huesca'],
            ['name' => 'Jaén'],
            ['name' => 'León'],
            ['name' => 'Lleida'],
            ['name' => 'Lugo'],
            ['name' => 'Madrid'],
            ['name' => 'Málaga'],
            ['name' => 'Murcia'],
            ['name' => 'Navarra'],
            ['name' => 'Ourense'],
            ['name' => 'Palencia'],
            ['name' => 'Palmas, Las'],
            ['name' => 'Pontevedra'],
            ['name' => 'Rioja, La'],
            ['name' => 'Salamanca'],
            ['name' => 'Santa Cruz de Tenerife'],
            ['name' => 'Segovia'],
            ['name' => 'Sevilla'],
            ['name' => 'Soria'],
            ['name' => 'Tarragona'],
            ['name' => 'Teruel'],
            ['name' => 'Toledo'],
            ['name' => 'Valencia/València'],
            ['name' => 'Valladolid'],
            ['name' => 'Zamora'],
            ['name' => 'Zaragoza'],
            ['name' => 'Ceuta'],
            ['name' => 'Melilla'],
        ]);
    }
}
