<?php

namespace Database\Factories;

use App\Models\Bobot;
use Illuminate\Database\Eloquent\Factories\Factory;

class BobotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bobot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Mudah',
            'nilai_bobot' => 27.5
        ];
    }
}
