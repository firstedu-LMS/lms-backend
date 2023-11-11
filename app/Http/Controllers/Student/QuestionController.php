<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\QuestionRequest;
use App\Models\CourseCompletion;
use App\Models\LessonCompletion;
use App\Models\Question;
use App\Models\QuestionSubmission;
use App\Models\WeekCompletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends BaseController
{
    public function getLessonQuestions($student_id, $lesson_id)
    {
        $question = Question::where('lesson_id', $lesson_id)->get();
        $questionSubmission = QuestionSubmission::where('lesson_id', $lesson_id)
            ->where('student_id', $student_id)
            ->first();
        if (!$question) {
            return $this->error([], 'there is no questions', config('http_status_code.not_found'));
        }
        if ($questionSubmission) {
            return $this->success(['question' => $question, 'score' => $questionSubmission->score], 'questions of lesson', config('http_status_code.ok'));
        } else {
            return $this->success(['question' => $question, 'score' => ''], 'questions of lesson', config('http_status_code.ok'));
        }
    }

    public function submission(Request $request)
    {
        $data = $request->except('answers', 'trueAnswers', 'week_id', 'batch_id', 'course_id');
        $answers = $request->answers;
        $trueAnswers = $request->trueAnswers;
        if (count($answers) != 0) {
            
            $percentage = count(array_intersect($answers, $trueAnswers)) / count($answers) * 100;
            $data['score'] = (int) substr((int)$percentage, 0, 3);
            $score = QuestionSubmission::create($data);

            $lessonCompletion = $request->except('answers', 'trueAnswers');
            LessonCompletion::create($lessonCompletion);
            
            $weekCompletion = WeekCompletion::where('student_id', $request->student_id)->where('course_id', $request->course_id)
                ->where('week_id', $request->week_id)
                ->where('batch_id', $request->batch_id)->first();

            if ($weekCompletion->lesson_count > $weekCompletion->lesson_completion_count) {
                $weekCompletion->lesson_completion_count++;
                $weekCompletion->update();
            }

            if ($weekCompletion->lesson_count == $weekCompletion->lesson_completion_count) {
                $courseCompletoin = CourseCompletion::where('course_id', $request->course_id)
                    ->where('student_id', $request->student_id)->first();
                logger($courseCompletoin);
                if ($courseCompletoin->week_count > $courseCompletoin->week_completion_count) {
                    $courseCompletoin->week_completion_count++;
                }
                $courseCompletoin->update();
            }

            return $this->success($score->score, 'submission score', config('http_status_code.ok'));
        } else {
            return $this->error([], 'answers are empty', config('http_status_code.unprocessable_content'));
        }
    }
}
