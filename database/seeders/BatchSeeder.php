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
        $number = 1;
        for($i =1 ; $i <=10 ; $i++) {
            DB::table('batches')->insert([
                'name' => 'Batch-' .$number++,
                "course_id" => 1,
                "instructor_id" => 1,
                "start_date" => Carbon::now()->toDateString(),
                "end_date" => Carbon::now()->addDay(30)->toDateString(),
                "start_time" => Carbon::now()->toTimeString(),
                "end_time" => Carbon::now()->addHour(3)->toTimeString(),
                "status" => fake()->numberBetween(0,1),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
            DB::table('batches')->insert([
                'name' => 'Batch-' .$number-1,
                "course_id" => 2,
                "instructor_id" => 2,
                "start_date" => Carbon::now()->toDateString(),
                "end_date" => Carbon::now()->addDay(30)->toDateString(),
                "start_time" => Carbon::now()->toTimeString(),
                "end_time" => Carbon::now()->addHour(3)->toTimeString(),
                "status" => fake()->numberBetween(0,1),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        }
        // DB::table('batches')->insert([
        //     [
        //         'name' => 'Batch-' .$number++,
        //         "course_id" => "1",
        //         "instructor_id" => "1",
        //         "start_date" => Carbon::now()->toDateString(),
        //         "end_date" => Carbon::now()->addDay(30)->toDateString(),
        //         "start_time" => Carbon::now()->toTimeString(),
        //         "end_time" => Carbon::now()->addHour(3)->toTimeString(),
        //         "status" => "1",
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()
        //     ],
            // [
            //     "name" => "Batch-1",
            //     "course_id" => "2",
            //     "instructor_id" => "2",
            //     "start_date" => Carbon::now()->toDateString(),
            //     "end_date" => Carbon::now()->addDay(30)->toDateString(),
            //     "start_time" => Carbon::now()->toTimeString(),
            //     "end_time" => Carbon::now()->addHours(3)->toTimeString(),
            //     "status" => "1",
            //     "created_at" => Carbon::now(),
            //     "updated_at" => Carbon::now()
            // ],
            // [
            //     "name" => "Batch-2",
            //     "course_id" => "1",
            //     "instructor_id" => "1",
            //     "start_date" => Carbon::now()->toDateString(),
            //     "end_date" => Carbon::now()->addDay(30)->toDateString(),
            //     "start_time" => Carbon::now()->toTimeString(),
            //     "end_time" => Carbon::now()->addHours(3)->toTimeString(),
            //     "status" => "1",
            //     "created_at" => Carbon::now(),
            //     "updated_at" => Carbon::now()
            // ],
            // [
            //     "name" => "Batch-2",
            //     "course_id" => "2",
            //     "instructor_id" => "1",
            //     "start_date" => Carbon::now()->toDateString(),
            //     "end_date" => Carbon::now()->addDay(30)->toDateString(),
            //     "start_time" => Carbon::now()->toTimeString(),
            //     "end_time" => Carbon::now()->addHours(3)->toTimeString(),
            //     "status" => "1",
            //     "created_at" => Carbon::now(),
            //     "updated_at" => Carbon::now()
            // ],
            // [
            //     "name" => "Batch-3",
            //     "course_id" => "1",
            //     "instructor_id" => "1",
            //     "start_date" => Carbon::now()->toDateString(),
            //     "end_date" => Carbon::now()->addDay(30)->toDateString(),
            //     "start_time" => Carbon::now()->toTimeString(),
            //     "end_time" => Carbon::now()->addHours(3)->toTimeString(),
            //     "status" => "1",
            //     "created_at" => Carbon::now(),
            //     "updated_at" => Carbon::now()
            // ],
            // [
            //     "name" => "Batch-3",
            //     "course_id" => "2",
            //     "instructor_id" => "1",
            //     "start_date" => Carbon::now()->toDateString(),
            //     "end_date" => Carbon::now()->addDay(30)->toDateString(),
            //     "start_time" => Carbon::now()->toTimeString(),
            //     "end_time" => Carbon::now()->addHours(3)->toTimeString(),
            //     "status" => "1",
            //     "created_at" => Carbon::now(),
            //     "updated_at" => Carbon::now()
            // ],
        // ]);
    }
}