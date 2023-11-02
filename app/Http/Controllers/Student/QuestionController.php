<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\QuestionRequest;
use App\Models\LessonCompletion;
use App\Models\Question;
use App\Models\QuestionSubmission;
use App\Models\WeekCompletion;
use Illuminate\Http\Request;

class QuestionController extends BaseController
{
   public function getLessonQuestions($lesson_id){
        $question = Question::where('lesson_id',$lesson_id)->get();
        $questionSubmission = QuestionSubmission::where('lesson_id',$lesson_id)->first();
        if (!$question) {
            return $this->error([], 'there is no questions', config('http_status_code.not_found'));
        }
        if ($questionSubmission) {
            return $this->success(['question'=>$question,'score'=>$questionSubmission->score],'questions of lesson',config('http_status_code.ok'));
        }else{
            return $this->success(['question'=>$question,'score'=> ''],'questions of lesson',config('http_status_code.ok'));
        }
   }

   public function submission(Request $request) {
        $data = $request->except('answers','trueAnswers','week_id','batch_id','course_id');
        $answers = $request->answers;
        $trueAnswers = $request->trueAnswers;
        $percentage = count(array_intersect($answers,$trueAnswers)) / count($answers) * 100;
        $data['score'] = (int) substr((int)$percentage, 0, 3);
        $score = QuestionSubmission::create($data);
        $lessonCompletion = $request->except('answers','trueAnswers');
        LessonCompletion::create($lessonCompletion);
        $weekCompletion = WeekCompletion::where('student_id',$request->student_id)->where('course_id',$request->course_id)->where('week_id',$request->week_id)->where('batch_id',$request->batch_id)->first();
        if ($weekCompletion->lesson_count > $weekCompletion->lesson_completion_count) {
            $weekCompletion->lesson_completion_count++;
        }
        $weekCompletion->update();
          return $this->success($score->score,'submission score',config('http_status_code.ok'));
   }

}
