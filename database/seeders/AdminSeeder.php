<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            'name' => 'admin',
            'email'=> 'admin@gmail.com',
            'password' => Hash::make('internet')
        ]);
        $admin = User::where('email','admin@gmail.com')->first();
        $admin->assignRole('admin');
    }
}
