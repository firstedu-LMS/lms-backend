<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Instructor;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Resources\InstructorResource;
use App\Http\Requests\AddInstructorRequest;

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

    public function removedApplication($email){
        $application = Application::where('email',$email)->first();
        $application->delete();
    }

    public function store(AddInstructorRequest $request){
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
        $this->removedApplication($user->email);
        return $this->success($instructor,'Created',config('http_status_code.created'));
   }
   public function index()
   {
    return $this->success(InstructorResource::collection(Instructor::with('cv')->get()),'All Instructor');
   }
   public function show($id)
   {
        $instructor = Instructor::where('id',$id)->with('cv')->first();
        if(!$instructor) {
            return $this->error([],'there is no instructor',config('http_status_code.not_found'));
        }
        return $this->success(new InstructorResource($instructor),'Instructor show for this id');
   }

   public function destroy(Instructor $instructor)
   {
       $instructor->delete();
       return $this->success([],'deleted',config('http_status_code.no_content'));
   }
}
