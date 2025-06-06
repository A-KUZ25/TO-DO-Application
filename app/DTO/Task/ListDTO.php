<?php

namespace App\DTO\Task;

use App\Http\Requests\Task\IndexRequest;

class ListDTO
{
    public function __construct(
        public readonly int     $perPage = 25,
        public readonly ?bool   $isCompleted = null,
        public readonly bool    $filterByStatus = false,
        public readonly ?string $sortBy = 'id',
        public readonly ?string $sortOrder = 'asc'
    )
    {
    }

    public static function fromRequest(IndexRequest $request): self
    {
        return new self(
            perPage: $request->validated('per_page'),
            isCompleted: $request->boolean('is_completed'),
            filterByStatus: $request->has('is_completed'),
            sortBy: $request->validated('sort_by', 'id'),
            sortOrder: $request->validated('sort_order', 'asc')
        );
    }
}
