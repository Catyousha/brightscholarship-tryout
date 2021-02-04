<?php

namespace Database\Factories;

use App\Models\Question;
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
            'tryout_id' => Tryout::factory(),
            'question_text' => $this->faker->text,
            'question_num' => 1
        ];
    }
}
