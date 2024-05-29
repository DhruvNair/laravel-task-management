<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realText(10),
            'description' => fake()->sentence(),
            'project_id' => fake()->numberBetween(1, 10),
            'assigned_to' => 1,
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed']),
            'deadline' => fake()->dateTimeBetween('now', '+1 year'),
        ];
    }
}
