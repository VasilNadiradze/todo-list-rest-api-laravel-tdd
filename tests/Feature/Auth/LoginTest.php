<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $user = $this->createUser();

        $response = $this->postJson(route('user.login'),[
            'email' => $user->email,
            'password' => 'password' // User::factory ადებს ამ პაროლს
        ])->assertOk();

        $this->assertArrayHasKey('token', $response->json());
    }

    public function test_incorrect_email()
    {
        $this->postJson(route('user.login'),[
            'email' => 'incorrect@mail.com',
            'password' => '12345'
        ])->assertUnauthorized();
    }

    public function test_incorrect_password()
    {
        $user = $this->createUser();

        $this->postJson(route('user.login'),[
            'email' => $user->email,
            'password' => 'arasworiparoli'
        ])->assertUnauthorized();
    }
}

