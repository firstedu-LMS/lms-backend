<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $instructorId = 1;
        $format = sprintf("%04d", $instructorId);
        $instructorId ++;
        $user = User::create([
            "name"=> fake()->name(),
            "email"=> fake()->unique()->safeEmail(),
            "password"=> Hash::make('internet'),
        ]);
        return [
            "student_id" =>"S-".$format,
            "phone" => "09 123 456 789",
            "address" => fake()->address(),
            "education" => "Hight School",
            "date_of_birth" => fake()->date(),
            "user_id" => $user->id,
        ];
    }
}
