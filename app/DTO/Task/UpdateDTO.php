<?php

namespace App\DTO\Task;

use App\Http\Requests\Task\SaveRequest;

class UpdateDTO
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $description,
        public readonly ?bool $isCompleted,
        public readonly bool $hasDescription = false
    ) {}

    public static function fromRequest(SaveRequest $request): self
    {
        return new self(
            title: $request->validated('title'),
            description: $request->validated('description'),
            isCompleted: $request->boolean('is_completed'),
            hasDescription: $request->has('description')
        );
    }
}
