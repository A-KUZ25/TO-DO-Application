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
}

