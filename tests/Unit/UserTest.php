<?php

namespace Tests\Unit;

use App\Models\TodoList;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_many_lists()
    {
        $user = $this->createUser();
        $list = TodoList::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(TodoList::class, $user->todo_lists->first());
    }
}
            
