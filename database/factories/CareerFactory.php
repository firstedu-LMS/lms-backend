<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Career>
 */
class CareerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->name(),
            "vacancy" => fake()->numberBetween(1,10),
            "age" => "over 20",
            "job_description" => fake()->text(),
            "job_requirement" => fake()->text(),
            "position" => fake()->name(),
            "salary" => fake()->numberBetween(200000,500000),
            "deadline" => fake()->date(),
            "salary_period" => Arr::random(["daily","monthly","yearly"]),
            "employment_status" => Arr::random(["full time","part time"])
        ];
    }
}
