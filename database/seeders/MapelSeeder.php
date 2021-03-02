<?php

namespace Database\Seeders;

use App\Models\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mapel::create(
            ['name' => 'Penalaran Umum']
        );
        Mapel::create(
            ['name' => 'Pemahaman Bacaan dan Menulis']
        );
        Mapel::create(
            ['name' => 'Pengetahuan dan Pemahaman Umum']
        );
        Mapel::create(
            ['name' => 'Pengetahuan Kuantitatif']
        );
        Mapel::create(
            ['name' => 'Matematika']
        );
        Mapel::create(
            ['name' => 'Fisika']
        );
        Mapel::create(
            ['name' => 'Kimia']
        );
        Mapel::create(
            ['name' => 'Biologi']
        );
        Mapel::create(
            ['name' => 'Sosiologi']
        );
        Mapel::create(
            ['name' => 'Ekonomi']
        );
        Mapel::create(
            ['name' => 'Geografi']
        );
        Mapel::create(
            ['name' => 'Sejarah']
        );
        Mapel::create(
            ['name' => 'ISTIRAHAT']
        );
    }
}
