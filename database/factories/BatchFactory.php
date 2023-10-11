<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Batch>
 */
class BatchFactory extends Factory

{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $number= 1;
        return [
            'name' => 'Batch-' .$number++,
            'course_id' => fake()->numberBetween(1,3),
            'instructor_id' => fake()->numberBetween(1,3),
            'start_date' => fake()->date('Y/m/d'),
            'end_date' => fake()->date('Y/m/d'),
            'start_time' => fake()->time(),
            'end_time' => fake()->time(),
            'status' => 1
        ];
    }
}
