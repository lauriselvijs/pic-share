<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user('admin')->can('update', $this->admin);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:admins',
            'role' => 'sometimes|required|exists:admin_roles,role',
            'notify' => 'sometimes|required|boolean'
        ];
    }
}
