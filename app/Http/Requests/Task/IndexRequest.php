<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{


    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'per_page' => 'nullable|integer|min:1|max:100',
            'is_completed' => 'nullable|boolean',
            'sort_by' => 'nullable|in:id,title,created_at',
            'sort_order' => 'nullable|in:asc,desc',
        ];

    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'per_page' => $this->input('per_page', 25),
            'sort_by' => $this->input('sort_by', 'id'),
            'sort_order' => $this->input('sort_order', 'asc'),
        ]);
    }
}

