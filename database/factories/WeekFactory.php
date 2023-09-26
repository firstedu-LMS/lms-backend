<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Week>
 */
class WeekFactory extends Factory
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
            "course_id" =>fake()->numberBetween(1,10),
            "batch_id" => fake()->numberBetween(1,10),
            "week_number" => "week-".$number++,
        ];
    }
}
