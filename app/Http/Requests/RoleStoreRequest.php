<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoleStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'application_id' => 'required|integer|exists:applications,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->where('application_id', $this->application_id)
            ],
            'description' => 'required|string|max:255'
        ];
    }
}
