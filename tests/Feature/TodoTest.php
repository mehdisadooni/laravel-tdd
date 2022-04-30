<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    private $todo;

    public function setUp(): void
    {
        parent::setUp();
        $user = $this->authUser();
        $this->todo = $this->createTodo(['user_id' => $user->id]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fetch_all_todos()
    {
        $this->createTodo();

        $response = $this->getJson(route('todos.index'))
            ->assertOk()
            ->json();

        $this->assertEquals(1, count($response));
        $this->assertEquals($this->todo->name, $response[0]['name']);
    }

    public function test_fetch_single_todo()
    {
        $response = $this->getJson(route('todos.show', $this->todo->id))
            ->assertOk()
            ->json();

        $this->assertEquals($this->todo->name, $response['name']);
    }

    public function test_store_new_todo()
    {
        $todo = Todo::factory()->make();

        $response = $this->postJson(route('todos.store'), ['name' => $todo->name])->assertCreated()->json();

        $this->assertEquals($todo->name, $response['name']);
        $this->assertDatabaseHas('todos', ['name' => $response['name']]);
    }

    public function test_while_storing_todo_name_field_is_required()
    {
        $this->withExceptionHandling()
            ->postJson(route('todos.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    public function test_delete_todo()
    {
        $this->deleteJson(route('todos.destroy', $this->todo->id))->assertNoContent();

        $this->assertDatabaseMissing('todos', ['id' => $this->todo->id]);
    }

    public function test_update_todo()
    {
        $newTodo = Todo::factory()->make();

        $response = $this->patchJson(route('todos.update', $this->todo->id), [
            'name' => $newTodo->name
        ])->assertOk()->json();

        $this->assertEquals($newTodo->name, $response['name']);
        $this->assertDatabaseHas('todos', ['id' => $this->todo->id, 'name' => $newTodo->name]);
    }

    public function test_while_updating_todo_name_field_is_required()
    {
        $this->withExceptionHandling()
            ->patchJson(route('todos.update', $this->todo->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }
}
