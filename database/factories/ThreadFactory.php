<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'title' => rtrim(fake()->sentence(6), '.').'?',
            'body' => fake()->paragraphs(2, true),
        ];
    }
}
