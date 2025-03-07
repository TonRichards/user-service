<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string||unique:permissions,name',
            'display_name' => 'nullable|string',
            'role_id' => 'nullable|integer|exists:roles,id',
        ];
    }
}
