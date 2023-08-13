<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ApplicationRequest extends FormRequest
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
            "email" => "required|email",
            "cv_id" => "required",
            "career" => "required"
        ];
    }
    public function messages()
    {
        return [
            "email" => ["required" => "Fill your :attribute address",]
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
