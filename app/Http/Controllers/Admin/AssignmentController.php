<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AssignmentRequest;
use App\Http\Resources\AssignmentResource;
use App\Models\Assignment;
use App\Utils\FormatJsonForResponseService\Admin\AssignmentJson;
use Illuminate\Http\Request;

class AssignmentController extends BaseController
{
    public function index()
    {
        $assignments = AssignmentResource::collection(Assignment::with(["course","batch","file"])->get());
        // $data = new AssignmentJson($assignments);
        // $assignments = $data->getJson();
        return $this->success(AssignmentResource::collection($assignments),"asignment datas");
    }
    public function store(AssignmentRequest $request)
    {
        $assignment =  Assignment::create($request->validated());
        return $this->success(new AssignmentResource($assignment),'created',config('http_status_code.created'));
    }

    public function show($id)
    {
        $assignment = Assignment::with(["course","batch","file"])->find($id);
        if(!$assignment) {
            return $this->error([], 'there is no assignment', config('http_status_code.not_found'));
        }
            $data = new AssignmentResource($assignment);
            $assignment = new AssignmentJson($data);
            $data = $assignment->getJson();
            return response()->json($data);
            return $this->success($data,"Detail of Assignment");
    }
    public function update(AssignmentRequest $request,$id)
    {
            $assignment = Assignment::where('id',$id)->first();
            if (!$assignment) {
                return $this->error([], 'there is no assignment', config('http_status_code.not_found'));
            }
            $data = $request->validated();
            $assignment->update($data);
            return $this->success(new Assignment([$assignment]), 'Updated assignment',config('http_status_code.ok'));
    }
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }
}
