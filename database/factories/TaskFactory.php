<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TodoList;

class TaskFactory extends Factory
{
    public function definition()
    {
        return [
            'todo_list_id' => function(){
                return TodoList::factory()->create()->id;
            },
            'title' => $this->faker->sentence()
        ];
    }
}
                  