<?php

namespace App\Http\Controllers\Admin;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Resources\InstructorResource;

class InstructorController extends BaseController
{
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
