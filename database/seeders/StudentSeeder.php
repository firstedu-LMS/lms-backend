<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i < 11; $i++) { 
           $userDataId = DB::table('users')->insertGetId([
                "name" => "Student".$i,
                "email" => "student".$i."@gmail.com",
                "image_id" => 2,
                "password" => Hash::make("internet"),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
            $userData = User::find($userDataId);
            $userData->assignRole('student');
            DB::table('students')->insert([
                "user_id" => $userDataId,
                "student_id" => "S-".sprintf("%04d", $i)
            ]);
        }
    }
}
