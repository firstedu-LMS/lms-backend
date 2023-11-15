<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends BaseController
{
    public function index($lesson)
    {
        return $this->success(QuestionResource::collection(Question::where('lesson_id', $lesson)->with('lesson')->get()), 'All courses');
    }

    public function store(QuestionRequest $request)
    {
        return $this->saveQuestion($request);
    }
    public function saveQuestion($request,$id = null)
    {
        $data = $request->validated();
        if($id) {
            $question = Question::where('id', $id)->first();
            if (!$question) {
                return $this->error([], 'there is no question', config('http_status_code.not_found'));
            }
            $question->update($data);
            return $this->success(new QuestionResource($question), 'Updated question', config('http_status_code.ok'));
        }else {
            $question = Question::create($data);
            return $this->success(new QuestionResource($question), 'Created', config('http_status_code.created'));
        }
    }
    public function show($id)
    {
        $question = Question::with('lesson')->find($id);
        if (!$question) {
            return $this->error([], 'there is no question', config('http_status_code.not_found'));
        }
        return $this->success(new QuestionResource($question), 'question show for this id');
    }
    public function destroy(Question $question)
    {
        $question->delete();
        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }
    public function update(QuestionRequest $request, $id)
    {
        return $this->saveQuestion($request,$id);
    }
}
