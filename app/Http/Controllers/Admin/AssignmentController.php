<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AssignmentRequest;
use App\Http\Resources\AssignmentResource;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends BaseController
{
    public function index()
    {
        return $this->success(AssignmentResource::collection(Assignment::with(["course","batch","file"])->get()),"All Assignments");
    }
    public function store(AssignmentRequest $request)
    {
        $assignment =  Assignment::created($request->validated());   
        return $this->success(new AssignmentResource($assignment),'created',config('http_status_code.created'));
    }
    
    public function show($id)
    {
        $assignment = Assignment::with(["course","batch","file"])->find($id);
        if(!$assignment) {
            return $this->error([], 'there is no assignment', config('http_status_code.not_found'));
        }
            return $this->success(new AssignmentResource($assignment),"Assignment is showing with this id");
    }
    public function update(AssignmentRequest $request,$id)
    {
        $assignment = Assignment::where('id',$id)->first();
            if (!$assignment) {
                return $this->error([], 'there is no assignment', config('http_status_code.not_found'));
            }
            // $assignment->title = $request->title;
            // $assignment->course_id = $request->course_id;
            // $assignment->batch_id = $request->batch_id;
            // $assignment->test_date = $request->test_date;
            // $assignment->test_time = $request->test_time;
            // $assignment->agenda = $request->agenda;
            // $assignment->file_id = $request->file_id;
            $assignment->update($request->validated());
            return $this->success(new Assignment([$assignment]), 'Updated assignment',config('http_status_code.ok'));
    }
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }
}
