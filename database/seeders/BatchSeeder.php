<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i =1 ; $i <=20 ; $i++) {
            $instructor_id = $course_id = ($i <= 10) ? 1 : 2;
            $batchid =($i <= 10) ? $i : ($i -10);
                DB::table('batches')->insert([
                    'name' => 'Batch-' .$batchid,
                    "course_id" => $course_id,
                    "instructor_id" => $instructor_id,
                    "start_date" => Carbon::now()->toDateString(),
                    "end_date" => Carbon::now()->addDay(30)->toDateString(),
                    "start_time" => Carbon::now()->toTimeString(),
                    "end_time" => Carbon::now()->addHour(3)->toTimeString(),
                    "status" => fake()->numberBetween(0,1),
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ]);
        }
    }
}