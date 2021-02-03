<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Tryout;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        User::factory(10)->create();
        Tryout::factory(10)->create();
    }
}
