<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Batch;
use App\Models\Instructor;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $number = 1;
        for($i =1 ; $i <= 4 ; $i++) {
            Instructor::insert([
                'user_id' => $i + 1,
                'instructor_id'=> $this->createInstructorId(),
                'cv_id'=> fake()->numberBetween(1,3),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        }
    }

    public function createInstructorId()
    {
        $instructor = Instructor::select('instructor_id')
            ->orderByDesc('instructor_id')
            ->value('instructor_id');
            $instructorIdOnly = substr($instructor, 2);
        if ($instructorIdOnly) {
            $instructorId = str_pad((int)$instructorIdOnly + 1, 4, "0", STR_PAD_LEFT);
        } else {
            $instructorId = config('instructorid.id');
        }
        return "I-" . $instructorId;
    }
}
