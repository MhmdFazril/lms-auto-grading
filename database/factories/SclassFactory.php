<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sclass>
 */
class SclassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nokey' => rand(1, 2),
            'students_id' => rand(1, 2),
            'teacher_id' => rand(1, 2),
            'mclass_id' => rand(1, 2),
            'major_id' => rand(1, 2),
            'academic_year_id' => rand(1, 2),
        ];
    }
}
