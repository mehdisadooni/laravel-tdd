<?php

namespace Tests\Unit;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_has_many_todos()
    {
        $user = $this->createUser();
        $this->createTodo(['user_id' => $user->id]);

        $this->assertInstanceOf(Todo::class, $user->todos->first());
    }
}
