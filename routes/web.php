<?php

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//This route will generate 5 
Route::get('/', function () {
    $numberOfInstructors = 5;
    for ($i=0; $i < $numberOfInstructors; $i++) { 
        $latestId = Instructor::select('id')
        ->orderByDesc('id')
        ->value('id');
        if ($latestId) {
            $newId =  (int)$latestId + 1;
            $instructorId =  str_pad((string)$newId, 4, '0', STR_PAD_LEFT);
        } else {
            $instructorId =  config('instructorid.id');
        }
            $user = new User();
            $user->name = fake()->name();
            $user->email = fake()->unique()->safeEmail();
            $user->password = Hash::make('internet');
            $user->save();
            $instructor = new Instructor();
            $instructor->user_id = $user->id;
            $instructor->instructor_id = $instructorId;
            $instructor->cv_id = 1;
            $instructor->save();
    }
    return "Finish";
});
