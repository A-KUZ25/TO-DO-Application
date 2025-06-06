<?php

namespace App\Traits;

use App\DTO\Task\UpdateDTO;

trait TaskUpdateData
{
    //Такие сложности нужны потому что description может быть явно null
    //а может быть просто не передан с фронта

    public function traitUpdateData(UpdateDTO $dto): array
    {
        return [
            ...$this->includeIfTitleProvided($dto),
            ...$this->includeIfDescriptionProvided($dto),
            ...$this->includeIfStatusProvided($dto),
        ];
    }

    private function includeIfTitleProvided(UpdateDTO $dto): array
    {
        return $dto->title !== null ? ['title' => $dto->title] : [];
    }

    private function includeIfDescriptionProvided(UpdateDTO $dto): array
    {
        return $dto->hasDescription ? ['description' => $dto->description] : [];
    }

    private function includeIfStatusProvided(UpdateDTO $dto): array
    {
        return $dto->isCompleted !== null ? ['is_completed' => $dto->isCompleted] : [];
    }
}
