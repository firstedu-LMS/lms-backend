<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;

class VideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'video'  => [
                            'required',
                            File::types(['mp4',])
                        ],
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
