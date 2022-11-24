<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png',
            'tags' => 'nullable|sometimes|string|filled',
            'price' => 'required|numeric|between:0,199999.99|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }
}
