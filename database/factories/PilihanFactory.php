<?php

namespace Database\Factories;

use App\Models\Pilihan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PilihanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pilihan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => "SAINTEK"
        ];
    }
}
