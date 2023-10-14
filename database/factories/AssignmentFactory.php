<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => fake()->name(),
            "course_id" => fake()->numberBetween(1,3),
            "batch_id" => fake()->numberBetween(1,3),
            "test_date" => fake()->date(),
            "test_time" => fake()->time(),
            "agenda" => fake()->text(),
            "file_id" => 1
        ];
    }
}
