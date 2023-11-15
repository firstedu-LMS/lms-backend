<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Instructor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class, 
            InstructorSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
            CourseSeeder::class,
            CareerSeeder::class,
            BatchSeeder::class,
            WeekSeeder::class,
            StudentSeeder::class,
            AssignmentScoreSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}