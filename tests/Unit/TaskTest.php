<?php

namespace Tests\Unit;


use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_task_belongs_to_a_todo()
    {
        $task = $this->createTask();
        $this->assertInstanceOf(Todo::class, $task->todo);
    }
}
