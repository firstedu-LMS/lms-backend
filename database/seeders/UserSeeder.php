<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
                        [
                            'name' => 'admin',
                            'email'=> 'admin@gmail.com',
                            'image_id' => 1,
                            'password' => Hash::make('internet'),
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ],
                        [
                            'name' => 'MKT',
                            'email' => 'mkt@gmail.com',
                            'image_id' => 1,
                            'password' => Hash::make('internet'),
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ],
                        [
                            'name' => 'Vadsha',
                            'email' => 'vadsha@gmail.com',
                            'image_id' => 1,
                            'password' => Hash::make('internet'),
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ],
                        [
                            'name' => 'Nage Nage',
                            'email' => 'nagenage@gmail.com',
                            'image_id' => 1,
                            'password' => Hash::make('internet'),
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ],
                        [
                            'name' => 'Han Htun',
                            'email' => 'hanhtun@gmail.com',
                            'image_id' => 1,
                            'password' => Hash::make('internet'),
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ],
                    ]);
    }
}
