<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $this->postJson(route('auth.register'), [
            'name' => 'mehdi',
            'email' => 'mehdi@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertCreated();

        $this->assertDatabaseHas('users', ['name' => 'mehdi']);
    }
}
