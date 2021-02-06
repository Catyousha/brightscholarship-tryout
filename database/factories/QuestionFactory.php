<?php

namespace Database\Factories;

use App\Models\Mapel;
use App\Models\Question;
use App\Models\Sesi;
use App\Models\Tryout;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tryout_id' => function (array $attributes) {
                return Sesi::find($attributes['sesi_id'])->tryout_id;
            },
            'mapel_id' => function (array $attributes) {
                return Sesi::find($attributes['sesi_id'])->mapel_id;
            },
            'sesi_id' => Sesi::factory(),
            'question_text' => $this->faker->text,
            'question_num' => 1
        ];
    }
}
