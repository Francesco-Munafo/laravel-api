<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'bail|required|min:5|max:50',
            'description' => 'bail|nullable|max:1000',
            'type_id' => ['nullable', 'exists:types,id'],
            'technology_id' => ['nullable', 'exists:technologies,id'],
            'image' => 'bail|nullable|image|max:5000',
            'git_link' => ['bail', 'nullable', Rule::unique('projects')],
            'external_link' => ['bail', 'nullable', Rule::unique('projects')],
            'publication_date' => 'bail|nullable|date',
        ];
    }
}
