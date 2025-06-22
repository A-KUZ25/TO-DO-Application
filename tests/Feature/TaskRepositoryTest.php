<?php

namespace Tests\Feature;

use App\DTO\Task\CreateDTO;
use App\DTO\Task\ListDTO;
use App\DTO\Task\ShowDTO;
use App\DTO\Task\UpdateDTO;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private TaskRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new TaskRepository();
    }

    public function test_it_returns_paginated_tasks_filtered_and_sorted(): void
    {
        Task::factory()->create(['title' => 'С', 'is_completed' => true]);
        Task::factory()->create(['title' => 'B', 'is_completed' => true]);
        Task::factory()->create(['title' => 'A', 'is_completed' => false]);

        $dto = new ListDTO(
            perPage: 10,
            isCompleted: true,
            filterByStatus: true,
            sortBy: 'title',
            sortOrder: 'asc'
        );

        $result = $this->repository->getPaginatedTasks($dto);

        $first = $result->items()[0] ?? null;

        $this->assertInstanceOf(Task::class, $first);
        $this->assertEquals('B', $first->title);
    }

    public function test_it_creates_task_from_dto(): void
    {
        $dto = new CreateDTO(
            title: 'New Task',
            description: 'Some description',
            isCompleted: false
        );

        $task = $this->repository->createTask($dto);

        $this->assertDatabaseHas('tasks', ['title' => 'New Task']);
        $this->assertSame('New Task', $task->title);
    }

    public function test_it_finds_task_by_id(): void
    {
        $task = Task::factory()->create();

        $dto = new ShowDTO(taskId: $task->id, withRelations: false);

        $found = $this->repository->findTask($dto);

        $this->assertTrue($task->is($found));
    }

    public function test_it_updates_task_using_dto(): void
    {
        $task = Task::factory()->create(['title' => 'Old']);

        $dto = new UpdateDTO(
            title: 'Updated',
            description: null,
            isCompleted: true,
            hasDescription: false
        );

        $updated = $this->repository->updateTask($dto, $task);

        $this->assertEquals('Updated', $updated->title);
        $this->assertEquals(true, $updated->is_completed);
    }

    public function test_it_deletes_task(): void
    {
        $task = Task::factory()->create();

        $this->repository->deleteTask($task);

        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }

}
