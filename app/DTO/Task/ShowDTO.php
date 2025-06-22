<?php

namespace App\DTO\Task;



use Illuminate\Http\Request;

class ShowDTO
{
    public function __construct(
        public readonly int $taskId,
        public readonly bool $withRelations = false
    ) {}

    public static function fromRequest(int $taskId, Request $request): self
    {
        return new self(
            taskId: $taskId,
            withRelations: $request->boolean('with_relations') //TODO: Прилепи связи с User
        );
    }
}
