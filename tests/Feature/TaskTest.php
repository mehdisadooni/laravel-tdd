<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;


    public function setUp(): void
    {
        parent::setUp();
        $this->authUser();
    }

    public function test_fetch_all_tasks_of_a_todo()
    {
        Task::factory()->count(10)->create();
        $task = Task::all()->random();

        $response = $this->getJson(route('todos.tasks.index', ['todo' => $task->todo_id]))->assertOk()->json();

        $this->assertEquals(1, count($response));
        $this->assertEquals($task->title, $response[0]['title']);
        $this->assertEquals($task->todo_id, $response[0]['todo_id']);
        $this->assertEquals($task->todo->id, $response[0]['todo_id']);
        $this->assertEquals($task->todo->id, $task->todo_id);
    }

    public function test_store_a_task_for_a_todo()
    {
        $todo = $this->createTodo();
        $task = Task::factory()->make();
        $label = $this->createLabel();
        $this->postJson(route('todos.tasks.store', ['todo' => $todo->id]), [
            'title' => $task->title,
            'description' => $task->description,
            'label_id' => $label->id,
        ])->assertCreated();

        $this->assertDatabaseHas('tasks', ['title' => $task->title, 'todo_id' => $todo->id, 'label_id' => $label->id]);
    }

    public function test_store_a_task_for_a_todo_without_label()
    {
        $todo = $this->createTodo();
        $task = Task::factory()->make();
        $this->postJson(route('todos.tasks.store', ['todo' => $todo->id]), [
            'title' => $task->title,
            'description' => $task->description,
        ])->assertCreated();

        $this->assertDatabaseHas('tasks', ['title' => $task->title, 'todo_id' => $todo->id, 'label_id' => null]);
    }


    public function test_delete_task_from_database()
    {
        $task = Task::factory()->create();

        $this->deleteJson(route('tasks.destroy', ['task' => $task->id]))->assertNoContent();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_update_task_of_todo()
    {
        $task = Task::factory()->create();
        $newTask = Task::factory()->make();

        $response = $this->patchJson(route('tasks.update', ['task' => $task->id]), [
            'title' => $newTask->title
        ])->assertOk()->json();

        $this->assertEquals($newTask->title, $response['title']);
        $this->assertDatabaseHas('tasks', ['title' => $newTask->title]);
    }

    public function test_a_task_status_can_be_change()
    {
        $task = $this->createTask();

        $this->patchJson(route('tasks.update', ['task' => $task->id]), [
            'status' => Task::STARTED,
            'title' => $task->title
        ])->assertOk()->json();

        $this->assertDatabaseHas('tasks', ['status' => Task::STARTED]);
    }
}
