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
            'time_start' => function (array $attributes) {
                return Tryout::find($attributes['tryout_id'])->time_start->addHours();
            },
            'time_end' => function (array $attributes) {
                return Tryout::find($attributes['tryout_id'])->time_start->addHours(1);
            },
            'istirahat' => 0
        ];
    }
}
