<?php

namespace Database\Factories;

use App\Models\Pilihan;
use App\Models\Tryout;
use Carbon\Carbon;
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
            'pilihan_id' => 1,
            'time_start' => Carbon::now(),
            'time_end' => Carbon::now()->addHours(8)
        ];
    }
}
