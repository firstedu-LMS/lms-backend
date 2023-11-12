<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i < 11; $i++) { 
           $userData = DB::table('users')->insertGetId([
                "name" => "Student".$i,
                "email" => "student".$i."@gmail.com",
                "image_id" => 2,
                "password" => "internet",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
            DB::table('students')->insert([
                "user_id" => $userData,
                "student_id" => "S-".sprintf("%04d", $i)
            ]);
        }
    }
}
