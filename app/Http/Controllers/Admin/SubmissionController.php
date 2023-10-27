<?php

namespace App\Http\Controllers\Admin;

use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\AssignmentScore;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Resources\SubmissionResource;
use App\Http\Requests\AssignmentScoreRequest;

class SubmissionController extends BaseController
{
    public function index()
    {
        $data = Submission::all();
        return $this->success(SubmissionResource::collection($data), "All submission data", config('http_status_code.ok'));
    }
    public function show($id)
    {
        $data = Submission::where('id', $id)->with(['submission_file'])->first();
        if ($data) {
            return $this->success(new SubmissionResource($data), "detail of submission", config('http_status_code.ok'));
        } else {
            return $this->error(["message" => "there is no submission"], "not found", config('http_status_code.not_found'));
        }
    }
    public function studentAssignmentScore(AssignmentScoreRequest $req)
    {
        AssignmentScore::create($req->validated());
        return $this->success([], "created assignmentScore", config('http_status_code.created'));
    }
}