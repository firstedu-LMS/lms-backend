<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Batch;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Models\CourseCompletion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;

class InstructorController extends BaseController
{
    public function instructor()
    {
        return Instructor::where('user_id',Auth::id())->with(['cv','user','user.image'])->first();
    }
    public function profile() {
        $instructor = $this->instructor();
        $currentCourse = Batch::where([
            'instructor_id' => $instructor->id,
            'status' => 1
        ])->pluck('course_id')->unique()->count();
        $finishedCourse = 1; //default value due to unknown logic
        return $this->success([
           'instructor' => [
            'instructor_id' => $instructor->instructor_id,
            'phone' => $instructor->phone,
            'address' => $instructor->address,
            'created_at' => $instructor->created_at->format('d-m-Y')
        ],
            'cv' => $instructor->cv,
            'user' => $instructor->user,
           'currentCourse' => $currentCourse,
           'finishedCourse' => $finishedCourse
        ],'Instructor Profile');
    }
    public function updateName(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->update();
        return $this->success($user->name,"updated name");
    }
    public function update(Request $request)
    {
        $instructor = Instructor::where('id', $this->instructor()->id)->first();
        foreach ($request->all() as $key => $value) {
            $instructor->$key = $value;
        }
        $instructor->update();
        return $this->success([
            'phone' => $instructor->phone,
            'address' => $instructor->address
        ], "Instructor info updated");
    }
}