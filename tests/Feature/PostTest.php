<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_posts(): void
    {
        $post = Post::factory()->create();

        $this->get(route('posts.show', $post))
            ->assertOk();
    }

    public function test_guest_cannot_create_post(): void
    {
        $this->get(route('posts.create'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_post(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('posts.store'), [
                'title' => 'My First Post',
                'content' => 'This is my first blog post.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'user_id' => $user->id,
            'title' => 'My First Post',
        ]);
    }

    public function test_author_can_update_own_post(): void
    {
        $user = User::factory()->create();

        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->put(route('posts.update', $post), [
                'title' => 'Updated Title',
                'content' => 'Updated content.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_other_user_cannot_update_post(): void
    {
        $post = Post::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($otherUser)
            ->put(route('posts.update', $post), [
                'title' => 'Unauthorized Update',
                'content' => 'Unauthorized content.',
            ])
            ->assertForbidden();
    }

    public function test_author_can_delete_own_post(): void
    {
        $user = User::factory()->create();

        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->delete(route('posts.destroy', $post))
            ->assertRedirect();

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

    public function test_other_user_cannot_delete_post(): void
    {
        $post = Post::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($otherUser)
            ->delete(route('posts.destroy', $post))
            ->assertForbidden();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
        ]);
    }
}
