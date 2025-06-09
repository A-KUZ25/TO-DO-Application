<?php

namespace App\Interfaces;

use App\DTO\Task\CreateDTO;
use App\DTO\Task\ListDTO;
use App\DTO\Task\ShowDTO;
use App\DTO\Task\UpdateDTO;
use App\Models\Task;


interface TaskRepositoryInterface
{
    public function getPaginatedTasks(ListDTO $dto);
    public function createTask(CreateDTO $dto): Task;
    public function findTask(ShowDTO $dto): Task;
    public function updateTask(UpdateDTO $dto, Task $task): Task;
    public function deleteTask(Task $task): void;

}
