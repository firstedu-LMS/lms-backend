<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Instructor;

class AddInstructorController extends BaseController
{
    public function createInstructorId(){
        $latestId = Instructor::select('instructor_id')
            ->orderByDesc('instructor_id')
            ->value('instructor_id');
        if($latestId){
            $instructorId = str_pad((string)$latestId + 1,4,"0",STR_PAD_LEFT);
        }else{
            $instructorId = config('instructorid.id');
        }
        return $instructorId;
    }

    public function store(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        $instructor = new Instructor();
        $instructor->instructor_id = $this->createInstructorId();
        $instructor->user_id = $user->id;
        $instructor->cv_id = $request->cv_id;
        $instructor->phone = $request->phone;
        $instructor->address = $request->address;
        $instructor->save();
        return $this->success($instructor,'Created',config('http_status_code.created'));
   }
}
