<?php

namespace App\Http\Controllers;

use App\DTO\Task\CreateDTO;
use App\DTO\Task\ListDTO;
use App\DTO\Task\ShowDTO;
use App\DTO\Task\UpdateDTO;
use App\Http\Requests\Task\IndexRequest;
use App\Http\Requests\Task\SaveRequest;
use App\Http\Resources\TaskFullResource;
use App\Http\Resources\TaskShortResource;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function __construct(
        private readonly TaskRepositoryInterface $repository
    )
    {}

    public function index(IndexRequest $request)
    {
        $dto = ListDTO::fromRequest($request);

        $tasks = $this->repository->getPaginatedTasks($dto);

        return TaskShortResource::collection($tasks);
    }


    public function store(SaveRequest $request)
    {
        $dto = CreateDTO::fromRequest($request);

        $task = $this->repository->createTask($dto);

        return new TaskFullResource($task);
    }


    public function show(Task $task)
    {
        $dto = ShowDTO::fromRequest($task->id);

        $task = $this->repository->findTask($dto);

        return new TaskFullResource($task);
    }


    public function update(SaveRequest $request, Task $task)
    {
        $dto = UpdateDTO::fromRequest($request);

        $updatedTask = $this->repository->updateTask($dto, $task);

        return new TaskFullResource($updatedTask);
    }


    public function destroy(Task $task)
    {
        //
    }
}
