<?php

namespace Database\Factories;

use App\Models\Label;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskFactory extends Factory
{
    use RefreshDatabase;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'todo_id' => Todo::factory()->create()->id,
            'label_id' => Label::factory()->create()->id
        ];
    }
}
