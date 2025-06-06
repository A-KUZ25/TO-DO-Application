<?php

namespace App\DTO\Task;

use App\Http\Requests\Task\SaveRequest;

class CreateDTO
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $description,
        public readonly bool $isCompleted = false
    ) {}

    public static function fromRequest(SaveRequest $request): self
    {
        return new self(
            title: $request->validated('title'),
            description: $request->validated('description'),
            isCompleted: $request->boolean('is_completed')
        );
    }
}
