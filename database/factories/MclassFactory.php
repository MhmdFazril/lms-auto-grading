<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mclass>
 */
class MclassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'deskripsi' => $this->faker->optional()->sentence(),
            // 'major_id' => rand(1, 2),
            // 'academic_year_id' => rand(1, 2),
        ];
    }
}
