<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('user')),
            ],
            'password' => 'nullable|string|min:6|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ];
    }
}
