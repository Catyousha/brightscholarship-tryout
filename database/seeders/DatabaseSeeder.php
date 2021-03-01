<?php

use App\Models\Tryout;
use Database\Seeders\AdminSeeder;
use Database\Seeders\BobotSeeder;
use Database\Seeders\MapelSeeder;
use Database\Seeders\PilihanSeeder;
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
        $this->call([
            BobotSeeder::class,
            PilihanSeeder::class,
            MapelSeeder::class,
            AdminSeeder::class,
            StudentSeeder::class,
            TryoutSeeder::class
        ]);
    }
}
