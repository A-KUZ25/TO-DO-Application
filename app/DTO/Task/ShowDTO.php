<?php

namespace App\DTO\Task;

use App\Http\Requests\Task\SaveRequest;

class ShowDTO
{
    public function __construct(
        public readonly int $taskId,
        public readonly bool $withRelations = false
    ) {}

    public static function fromRequest(int $taskId): self
    {
        return new self(
            taskId: $taskId,
            withRelations: request()->boolean('with_relations') //TODO: Прилепи связи с User
        );
    }
}
