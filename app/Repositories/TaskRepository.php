<?php

namespace App\Repositories;

use App\DTO\Task\CreateDTO;
use App\DTO\Task\ListDTO;
use App\DTO\Task\ShowDTO;
use App\DTO\Task\UpdateDTO;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use App\Traits\TaskUpdateData;
use Illuminate\Contracts\Pagination\Paginator;

class TaskRepository implements TaskRepositoryInterface
{

    use TaskUpdateData;

    public function getPaginatedTasks(ListDTO $dto): Paginator
    {
        return Task::query()
            ->status($dto->isCompleted, $dto->filterByStatus)
            ->orderBy($dto->sortBy, $dto->sortOrder)
            ->simplePaginate($dto->perPage);
    }

    public function createTask(CreateDTO $dto): Task
    {
        return Task::create([
            'title' => $dto->title,
            'description' => $dto->description,
            'is_completed' => $dto->isCompleted
        ]);
    }

    public function findTask(ShowDTO $dto): Task
    {
        return Task::query()
            //->when($dto->withRelations, fn ($q) => $q->with('user')) //TODO: Связи!
            ->findOrFail($dto->taskId);
    }

    public function updateTask(UpdateDTO $dto, Task $task): Task
    {
        $data = $this->traitUpdateData($dto);

        $task->update($data);

        return $task->fresh();
    }

}
