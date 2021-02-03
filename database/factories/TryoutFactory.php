<?php

namespace Database\Factories;

use App\Models\Tryout;
use Illuminate\Database\Eloquent\Factories\Factory;

class TryoutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tryout::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => "Tryout Test",
            'time_start' => $this->faker->dateTimeBetween('-1 days'),
            'time_end' => $this->faker->dateTimeBetween('now')
        ];
    }
}
