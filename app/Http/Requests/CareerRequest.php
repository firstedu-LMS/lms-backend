<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CareerRequest extends FormRequest
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
            'name' => 'required',
            'vacancy' => 'required',
            'age' => 'required',
            'job_description' => 'required',
            'job_requirement' => 'required',
            'deadline' => "required",
            'position' => 'required',
            'salary' => 'required',
            'salary_period' => 'required',
            'employment_status' => 'required'
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
 