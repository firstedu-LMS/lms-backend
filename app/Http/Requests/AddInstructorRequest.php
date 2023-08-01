<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class AddInstructorRequest extends FormRequest
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
            "name" => "required",
            "email" => "required|unique:users,email|email",
            "password" => "required",
            "cv_id" => "required",
            "phone" => "required",
            "address" => "required"
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator,response()->json([
            "errors" => $validator->errors(),
            "messages" => "Validation Errors",
        ],422));
    }
}
