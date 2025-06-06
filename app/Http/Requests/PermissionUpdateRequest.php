<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:permissions,name',
            'label_en' => 'nullable|string',
            'label_th' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_th' => 'nullable|string',
        ];
    }
}