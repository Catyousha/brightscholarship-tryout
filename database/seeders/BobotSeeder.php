<?php

namespace Database\Seeders;

use App\Models\Bobot;
use Illuminate\Database\Seeder;

class BobotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bobot::create([
            'name' => 'Mudah',
            'nilai_bobot' => 27.5
        ]);
        Bobot::create([
            'name' => 'Sedang',
            'nilai_bobot' => 50
        ]);
        Bobot::create([
            'name' => 'Sulit',
            'nilai_bobot' => 80
        ]);
    }
}
