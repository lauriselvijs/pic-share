<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('edit', $this->post);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|required|string',
            'image' => ['sometimes', 'required', File::types(['jpeg', 'png'])
                ->min(config('constants.min_file_size'))
                ->max(config('constants.max_file_size'))],
            'tags' => 'nullable|sometimes|string',
        ];
    }
}
