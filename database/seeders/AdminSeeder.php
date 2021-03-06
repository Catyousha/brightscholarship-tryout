<?php

namespace Database\Seeders;

use App\Models\Pilihan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pilihan = Pilihan::all();

        User::factory(1)->state(new Sequence(
            [
                'email' => 'admin@example.com',
                'pilihan_id' => $pilihan->get(0)->id,
                'role' => 'admin'
                ]
        ))->create();
    }
}
