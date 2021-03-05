<?php

namespace Database\Seeders;

use App\Models\Pilihan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $pilihan = Pilihan::all();
        User::factory(10)->state(new Sequence(
            ['pilihan_id' => $pilihan->get(0)->id],
            ['pilihan_id' => $pilihan->get(1)->id, 'acc_verified_at' => null],
            ['pilihan_id' => $pilihan->get(2)->id, 'acc_verified_at' => null]
        ))->create();

    }
}
