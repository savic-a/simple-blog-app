<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
            'guest_name' => null,
            'comment' => fake()->paragraph(),
        ];
    }

    public function asGuest(): static
    {
        return $this->state(fn () => [
            'user_id' => null,
            'guest_name' => fake()->name(),
        ]);
    }
}
