<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class AuthRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        if (request()->route()->getName() == 'register') {
            return [
                'name' => "required|min:4|max:24",
                'email' => "required|email|unique:users,email",
                'password' => "required|min:6|confirmed"
            ];
        } else {
            return [
                'email' => "required|email",
                'password' => "required|min:6"
            ];
        }

    }
    public function messages()
    {
        return [
            'required' => 'You must fill the :attribute field.',
            'email' => 'You need to fill up a valid email address.',
            'unique' => 'There is a user with this email',
            'confirmed' => 'You need to confirm the :attribute'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'full name',
            'email' => 'email address'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator , response()->json([
            'errors' => $validator->errors()
        ],422));
    }
}
