<?php

namespace Database\Seeders;

use App\Models\Career;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Career::insert([
            [
                'name' => 'Software Developer',
                'vacancy' => 5,
                'age' => 'Over 18',
                'job_description' => 'Develop and maintain software applications.',
                'job_requirement' => 'Bachelor\'s degree in Computer Science, experience with PHP and Laravel.',
                'position' => 'Full-time',
                'salary' => '$60,000',
                'deadline' => Carbon::now()->addWeeks(2)->toDateString(),
                'salary_period' => 'Annually',
                'employment_status' => 'Permanent',
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
            [
                'name' => 'Marketing Specialist',
                'vacancy' => 3,
                'age' => 'Over 21',
                'job_description' => 'Create and implement marketing strategies.',
                'job_requirement' => 'Bachelor\'s degree in Marketing, experience in digital marketing.',
                'position' => 'Part-time',
                'salary' => '$40,000',
                'deadline' => Carbon::now()->addWeeks(3)->toDateString(),
                'salary_period' => 'Annually',
                'employment_status' => 'Contract',
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
            [
                'name' => 'Graphic Designer',
                'vacancy' => 2,
                'age' => 'Over 20',
                'job_description' => 'Design visually appealing graphics for various projects.',
                'job_requirement' => 'Degree in Graphic Design, proficiency in Adobe Creative Suite.',
                'position' => 'Full-time',
                'salary' => '$45,000',
                'deadline' => Carbon::now()->addWeeks(4)->toDateString(),
                'salary_period' => 'Annually',
                'employment_status' => 'Permanent',
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
            [
                'name' => 'Customer Support Representative',
                'vacancy' => 8,
                'age' => 'Over 18',
                'job_description' => 'Assist customers with inquiries and provide excellent support.',
                'job_requirement' => 'High school diploma, strong communication skills.',
                'position' => 'Full-time',
                'salary' => '$35,000',
                'deadline' => Carbon::now()->addWeeks(2)->toDateString(),
                'salary_period' => 'Annually',
                'employment_status' => 'Permanent',
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
            [
                'name' => 'Data Analyst',
                'vacancy' => 4,
                'age' => 'Over 22',
                'job_description' => 'Analyze and interpret complex data sets.',
                'job_requirement' => 'Bachelor\'s degree in Statistics or related field, proficiency in data analysis tools.',
                'position' => 'Full-time',
                'salary' => '$55,000',
                'deadline' => Carbon::now()->addWeeks(3)->toDateString(),
                'salary_period' => 'Annually',
                'employment_status' => 'Permanent',
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now(),
            ],
        ]);
    }
}