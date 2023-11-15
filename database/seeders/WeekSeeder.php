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

        for($week = 1 ; $week <= 30 ; $week++){
            $course_id = $week <= 15 ? 1 : 2;
            if ($week <= 15) {
                $batch_id = ceil($week / 5);
            } else {
                $batch_id = ceil(($week - 15) / 5) + 10;
            }
            $week_number = $week <= 5 ? $week : ($week - 1) % 5 + 1;
                DB::table('weeks')->insert([
                    "course_id" => $course_id,
                    "batch_id" => $batch_id,
                    "week_number" => "week-" .$week_number,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ]);
            }

        }
}