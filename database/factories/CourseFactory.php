<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    public $status = ['online','offline','internship'];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'image_id'     => 1 ,
            'age' => 'over 18',
            'fee' => fake()->numberBetween(100, 200),
            'status' => Arr::random($this->status) ,
            'available' => Arr::random([true,false]),
        ];
    }
}
