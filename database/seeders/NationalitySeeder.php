<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = Storage::disk('public')->get('countries_list.txt');
        $data = json_decode($file, true);
        $list = [];
        foreach ($data as $item) {
            $list[] = [
                'name' => $item['name_en'],
                'flag' => $item['flag'],
            ];
        }
        Country::insert($list);
    }
}
