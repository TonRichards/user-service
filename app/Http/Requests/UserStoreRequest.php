<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6|confirmed',
            'organizations' => 'nullable|array',
            'organizations.*.organization_id' => 'required|exists:organizations,id',
            'organizations.*.role'            => 'required|exists:roles,id',
        ];
    }
}
