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
            'application_id' => 'required|string',
            'organization_id' => 'required|string',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')
                    ->ignore($this->route('id'))
                    ->where(fn ($query) => $query->where('application_id', $this->get('application_id'))
                        ->where('organization_id', $this->user()->current_organization_id)
                ),
            ],
            'display_name' => 'required|string|max:255',
            'permission_names' => 'array',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'organization_id' => $this->user()->current_organization_id,
        ]);
    }
}
