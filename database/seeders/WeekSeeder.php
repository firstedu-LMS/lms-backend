<?php

namespace Database\Seeders;

use App\Models\Week;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $number = 1;
        for($week = 0 ; $week <= 5 ; $week++){
            Week::insert([
                [
                    "course_id" => 1,
                    "batch_id" => 1,
                    "week_number" => "week-" .$number++,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ],
                [
                    "course_id" => 1,
                    "batch_id" => 2,
                    "week_number" => "week-" .$number++,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ],
                [
                    "course_id" => 2,
                    "batch_id" => 1,
                    "week_number" => "week-" .$number++,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ],
                [
                    "course_id" => 2,
                    "batch_id" => 2,
                    "week_number" => "week-" .$number++,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ],
               
            ]);
        }
       
    }
}
