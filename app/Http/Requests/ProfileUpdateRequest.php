<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ProfileUpdateRequest extends FormRequest
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
            'name' => 'min:4|max:25',
            'lastName' => 'min:4|max:35',
            'location' => 'string|min:4|max:25',
            'age' => 'number|min:18|max:110',
            'isBanned' => 'boolean',
            'longDescription' => 'string|min:4|max:255',
            'shortDescription' => 'string|min:4|max:50',
            'linkedIn' => 'string|min:8|max:30|unique:profiles',
            'avatarImage' => 'string',
            'backgroundImage' => 'string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(['errors' => $errors], 400)
        );
    }
}
