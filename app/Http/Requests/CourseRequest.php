<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CourseRequest extends FormRequest
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
           "category_id" => ["required"],
           "name" => ["required","min:4"],
           "description" => ["required","min:4"],
           "fee" => ["required","numeric"],
           "age" => ["required"],
           "status" => ["required","min:4"],
           "available" => ["required"]
        ];
    }
    public function messages(): array
    {
        return [
            'required' => 'please fill course :attribute',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'errors' => $validator->errors(),
            'message' => 'Validation Errors'
        ],422));
    }
}
