<?php

namespace App\Repositories;

use App\DTO\Task\CreateDTO;
use App\DTO\Task\ListDTO;
use App\DTO\Task\ShowDTO;
use App\DTO\Task\UpdateDTO;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Contracts\Pagination\Paginator;

class TaskRepository implements TaskRepositoryInterface
{



    public function getPaginatedTasks(ListDTO $dto): Paginator
    {
        return Task::query()
            ->status($dto->isCompleted, $dto->filterByStatus)
            ->orderBy($dto->sortBy, $dto->sortOrder)
            ->select('id', 'title', 'is_completed')
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
        $data = $dto->toUpdateArray();

        $task->fill($data)->save();

        return $task->fresh();
    }

    public function deleteTask(Task $task): void
    {
        $task->delete();
    }
}
