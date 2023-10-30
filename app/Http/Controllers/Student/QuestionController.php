<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends BaseController
{
   public function getLessonQuestions($lesson_id){
        $question = Question::where('lesson_id',$lesson_id)->get();
        if ($question->count() == 0 ) {
            return $this->error([], 'there is no questions', config('http_status_code.not_found'));
        }
        return $this->success($question,'questions of lesson',config('http_status_code.ok'));
   }
   
   public function submission(Request $request) {
        return $this->success($request->all(),'submission',config('http_status_code.ok'));
   }

}
