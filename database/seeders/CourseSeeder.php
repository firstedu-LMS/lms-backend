<?php

namespace Database\Seeders;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::insert([
            [
                "name" => "English",
                "description" => "English language learning will allow you to communicate effectively with people from all over the world, making travelling a lot easier and helping you to learn more about different cultures. The importance of English language can be seen in almost every aspect of our lives.",
                "image_id" => 1,
                "fee" => 20000,
                "age" => "over 15",
                "status" => "offline",
                "available" => true,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "name" => "Computer Basic",
                "description" => "Learning computer programming ensures that students have access to the creative, fast-paced world that relies on machine connections. Students can apply these skills to so many different industries and disciplines. Students that want a creative job can delve into 3D animation, web design, or even branding.",
                "image_id" => 1,
                "fee" => 40000,
                "age" => "over 15",
                "status" => "offline",
                "available" => true,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "name" => "Networking",
                "description" => "Having a strong understanding of computer networking can help you demonstrate knowledge that makes you a stronger candidate for certain positions. Systems administrators, network administrators , network technicians and network engineers all need to understand networking.",
                "image_id" => 1,
                "fee" => 40000,
                "age" => "over 15",
                "status" => "online",
                "available" => true,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "name" => "computer programming",
                "description" => "Adding a programming language to your skill set can demonstrate your abilities. It can also complement your current knowledge. If you work in a people-focused career, learning to code can strengthen your reasoning and logic skills. And if you're in an analytical field, coding can sharpen your ability to work with data.",
                "image_id" => 1,
                "fee" => 50000,
                "age" => "over 18",
                "status" => "offline",
                "available" => true,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "name" => "graphic",
                "description" => "By studying graphic design, you'll learn the basics of composition, colour, and typography, which are essential for creating effective visuals. You'll also develop problem-solving skills that will come in handy when designing for clients.",
                "image_id" => 1,
                "fee" => 50000,
                "age" => "over 18",
                "status" => "online",
                "available" => false,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            ]);
    }
}
