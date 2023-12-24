<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Batch;
use App\Models\Image;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\InstractorPasswordChangeRequest;
use Illuminate\Support\Facades\Hash;

class InstructorController extends BaseController
{

    public function instructor()
    {
        return Instructor::where('user_id',Auth::id())->with(['cv','user','user.image'])->first();
    }

    public function profile()
    {
        $instructor = $this->instructor();

        $currentCourse = Batch::where([
            'instructor_id' => $instructor->id,
            'status' => 1
        ])->pluck('course_id')->unique()->count();

        $finishedCourse = Batch::where([
            'instructor_id' => $instructor->id,
            'status' => 0
        ])->count();

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

    public function updateImage(Request $request)
    {
        $unlinkImage = Image::where('id',Auth::user()->image_id)->first();
        unlink(storage_path("app/".$unlinkImage->image));
        $unlinkImage->delete();
        $file = storeFile($request->file('image'),'user_image');
        $image =  Image::create([
            'image'=> $file
        ]);
        $user = Auth::user();
        $user->image_id = $image->id;
        $user->update();
        return $this->success($image,"updated image");
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

    public function changePassword(InstractorPasswordChangeRequest $request) {
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->update();
            return $this->success([],'successfully changed password');
        }
        return $this->error([],'Wrong Password!',400);
    }

    public function getInstructorCourses(){
        $data = Batch::where('instructor_id',$this->instructor()->id)->with('course.image')->get();
        $courses = [];
        for ($i=0; $i < count($data); $i++) {
            $courses[$i] = [
                "course_id" => $data[$i]->course_id,
                "course_name" => $data[$i]->course->name,
                "image" => $data[$i]->course->image->image,
                "batch_id" => $data[$i]->id,
                "batch_name" => $data[$i]->name,
                "instructor_id" => $data[$i]->instructor_id
            ];
        }
        return $this->success($courses , "courses");
    }
}
