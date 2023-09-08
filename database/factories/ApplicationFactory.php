<?php

namespace Database\Factories;

use App\Models\CvForm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'career' => fake()->title(),
            'email' => fake()->unique()->safeEmail,
            'cv_id' => CvForm::factory()
        ];
    }
}
