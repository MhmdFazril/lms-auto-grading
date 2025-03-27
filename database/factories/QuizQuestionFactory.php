<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizQuestion>
 */
class QuizQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_content_id' => '1',
            'question_text' => $this->faker->sentence(),
            'question_type' => 'essai',
            'correct_answer' => $this->faker->sentence(),
        ];
    }
}
