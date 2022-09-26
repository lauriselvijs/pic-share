<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO:
        // [] - Replace with policies
        if ($this->post->user_id == auth()->id()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|string',
            'image' => 'sometimes|image|mimes:jpeg,png',
            'tags' => 'nullable|sometimes|string|filled',
        ];
    }
}
