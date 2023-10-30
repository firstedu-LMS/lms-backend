<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class QuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'lesson_id' => $this->lesson_id,
            'student_id' => $this->student_id,
            'week_id' => $this->week_id,
            'course_id' => $this->course_id,
            'batch_id' => $this->batch_id,
            'answers' => $this->answers,
            'trueAnswers' =>  $this->trueAnswers
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'errors' => $validator->errors(),
            'message' => 'Validation Errors'
        ],config('http_status_code.unprocessable_content')));
    }
}
