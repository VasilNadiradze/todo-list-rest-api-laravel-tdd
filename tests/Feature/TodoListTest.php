<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TodoList;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    private $list;

    public function setUp():void
    {
        parent::setUp();
        $user = $this->authUser();
        $this->list = TodoList::factory()->create([
            'name' => 'my list',
            'user_id' => $user->id
        ]);
    }

    public function test_todo_list_index()
    {
        // ქმედება
        $response = $this->getJson(route('todo-list.index'));

        // მტკიცება
        $this->assertEquals(1, count($response->json()));
        $this->assertEquals('my list', $response->json()[0]['name']);
    }

    public function test_fetch_single_todo_list()
    {
        $response = $this->getJson(route('todo-list.show', $this->list->id))
                ->assertOk()
                ->json();

        $this->assertEquals($response['name'], $this->list->name);
    }

    public function test_store_new_todo_list()
    {
        $list = TodoList::factory()->make();
        $response = $this->postJson(route('todo-list.store'),[
            'name' => $list->name,
            'user_id' => $this->authUser()->id
        ])
        ->assertCreated()
        ->json();

        $this->assertEquals($list->name, $response['name']);
        $this->assertDatabaseHas('todo_lists',['name' => $list->name]);
    }

    public function test_name_field_validation()
    {
        /*
         * ამ ჩანაწერის გარეშე ლარაველი დაგვიგენერირებს ვალიდაციასთან
         * დაკავშირებულ გამონაკლისს და ტესტი არ შესრულდება
         */
        $this->withExceptionHandling();

        $response = $this->postJson(route('todo-list.store'))
                ->assertUnprocessable(); // იგივე assertStatus(422)

        $response->assertJsonValidationErrors(['name']);
    }

    public function test_delete_todo_list()
    {
        // შეხსენება : $this->list აღწერილი გვაქვს TodoListTest კლასის setUp() მეთოდში
        $this->deleteJson(route('todo-list.destroy', $this->list))
                ->assertNoContent(); // იგივე assertStatus(204)

        $this->assertDatabaseMissing('todo_lists',['name' => $this->list->name]);
    }

    public function test_update_todo_list()
    {
        $this->putJson(route('todo-list.update', $this->list),['name' => 'updated name'])
                ->assertOk();

        $this->assertDatabaseHas('todo_lists',[
            'id' => $this->list->id,
            'name' => 'updated name'
        ]);
    }
}