<?php

namespace App\Http\Requests\Register;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'token' => ['required'],
            'name' => ['required', 'string', 'min:1', 'max:60'],
            'email' => ['required', 'string', 'email', 'min:2', 'max:100'],
            'phone' => ['required', 'string', 'regex:/^\+380([0-9]{9})$/'],
            'position_id' => ['required', 'integer', 'min:1'],
            'photo' => ['required', 'file', 'image', 'max:5120', 'mimes:jpeg,jpg'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'fails' => $validator->errors(),
        ], 422));
    }
}
