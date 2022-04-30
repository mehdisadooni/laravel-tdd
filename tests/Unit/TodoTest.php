<?php

namespace Tests\Unit;


use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_todo_can_has_many_tasks()
    {
        $task = $this->createTask();
        $todo = $task->todo;
        $this->assertInstanceOf(Collection::class, $todo->tasks);
        $this->assertInstanceOf(Task::class, $todo->tasks->first());
    }

    public function test_if_task_is_deleted_then_all_its_tasks_will_be_deleted()
    {
        $task = $this->createTask();
        $todo = $task->todo;
        $anotherTask = $this->createTask();

        $todo->delete();

        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $this->assertDatabaseHas('tasks', ['id' => $anotherTask->id]);
    }

}
