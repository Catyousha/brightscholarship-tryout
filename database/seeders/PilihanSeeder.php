<?php

namespace Database\Seeders;

use App\Models\Pilihan;
use Illuminate\Database\Seeder;

class PilihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo("P");
        Pilihan::create([
            'name' => 'SAINTEK'
        ]);
        Pilihan::create([
            'name' => 'SOSHUM'
        ]);
        Pilihan::create([
            'name' => 'CAMPURAN'
        ]);
    }
}
