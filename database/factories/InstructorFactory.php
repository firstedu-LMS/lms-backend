<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Instructor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instructor>
 */
class InstructorFactory extends Factory
{


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
            "instructor_id" =>"I-".$format,
            "phone" => "09 123 456 789",
            "address" => "Hlaing TharYar",
            "cv_id" => 1,
            "user_id" => $user->id,
        ];
    }
}
