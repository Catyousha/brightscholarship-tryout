<?php

use App\Models\Tryout;
use Database\Seeders\StudentSeeder;
use Database\Seeders\TryoutSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([StudentSeeder::class, TryoutSeeder::class]);
    }
}
