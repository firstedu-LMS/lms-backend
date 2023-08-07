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
        $instructor = Instructor::select('instructor_id')
        ->orderByDesc('instructor_id')
        ->value('instructor_id');
        $instructorIdOnly = substr($instructor,2);
        if($instructorIdOnly){
            "I-". $instructorId = str_pad((int)$instructorIdOnly +1 ,4,"0",STR_PAD_LEFT);
        }else{
            "I-".$instructorId = config('instructorid.id');
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
