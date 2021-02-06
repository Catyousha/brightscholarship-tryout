<?php

namespace Database\Factories;

use App\Models\Mapel;
use App\Models\Sesi;
use App\Models\Tryout;
use Illuminate\Database\Eloquent\Factories\Factory;

class SesiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sesi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tryout_id' => Tryout::factory(),
            'mapel_id' => 1,
            'time_start' => $this->faker->dateTimeBetween('-1 days'),
            'time_end' => $this->faker->dateTimeBetween('2 days', '3 days')
        ];
    }
}
