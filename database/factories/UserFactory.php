<?php

namespace Database\Factories;

use App\Models\Pilihan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => 'student',
            'pilihan_id' => Pilihan::factory(),
            'asal_sekolah' => "SMA 01 ".$this->faker->city,
            'foto_profil' => $this->faker->image(storage_path('app/public/foto_profil/'), 640, 480, 'cats', false),
            'acc_verified_at' => now()
        ];
    }
}
