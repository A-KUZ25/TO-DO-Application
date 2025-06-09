<?php


use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_tasks()
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson(route('tasks.index'));

        $response->assertOk()
            ->assertJsonStructure(['data' => [['id', 'title']]]);
    }

    public function test_store_creates_new_task()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Description',
            'is_completed' => false,
        ];

        $response = $this->postJson(route('tasks.store'), $data);

        $response->assertCreated()
            ->assertJsonFragment(['title' => 'Test Task']);

        $this->assertDatabaseHas('tasks', ['title' => 'Test Task', 'description' => 'Description']);
    }

    public function test_show_returns_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson(route('tasks.show', $task));

        $response->assertOk()
            ->assertJsonFragment(['id' => $task->id]);
    }

    public function test_update_changes_task()
    {
        $task = Task::factory()->create();

        $data = ['title' => 'Updated title'];

        $response = $this->putJson(route('tasks.update', $task), $data);

        $response->assertOk()
            ->assertJsonFragment(['title' => 'Updated title']);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated title']);
    }


    public function test_destroy_deletes_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson(route('tasks.destroy', $task));

        $response->assertNoContent();

        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }
}
