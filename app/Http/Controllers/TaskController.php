<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\IndexRequest;
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
        $validated = $request->validated();

        $perPage = $validated['per_page'] ?? 25;

        $tasks =  $this->repository->getPaginatedTasks($perPage);

        return TaskShortResource::collection($tasks);
    }


    public function store(Request $request)
    {

    }


    public function show(Task $task)
    {

    }


    public function update(Request $request, Task $task)
    {

    }


    public function destroy(Task $task)
    {
        //
    }
}
