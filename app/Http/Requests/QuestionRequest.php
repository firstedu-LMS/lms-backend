<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
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
            "lesson_id" => "required",
            "title" => "required",
            "choice1" => "required",
            "choice2" => "required",
            "choice3" => "required",
            "answer" => "required"
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator,response()->json([
            "errors" => $validator->errors(),
            "messages" => "Validation Errors",
        ],config('http_status_code.unprocessable_content')));
    }
}
