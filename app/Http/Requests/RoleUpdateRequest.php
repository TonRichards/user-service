<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'application_id' => 'required|string|exists:applications,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->where('application_id', $this->application_id)
            ],
            'display_name' => 'required|string|max:255'
        ];
    }
}
