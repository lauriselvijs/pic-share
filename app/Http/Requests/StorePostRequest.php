<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
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
            'image' => ['required', File::types(['jpeg', 'png'])
                ->min(config('constants.min_file_size'))
                ->max(config('constants.max_file_size'))],
            'tags' => 'nullable|string',
            'price' => 'required|numeric|between:0,199999.99|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }
}
