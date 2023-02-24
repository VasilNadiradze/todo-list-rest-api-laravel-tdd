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
        $this->postJson(route('user.register'),[
            'name' => 'vaso',
            'email' => 'vaso@gmail.com',
            'password' => '12345',
            'password_confirmation' => '12345'
        ])->assertcreated();

        $this->assertDatabaseHas('users', ['name' => 'vaso']);
    }
}

