<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
     use RefreshDatabase;

    public function test_guest_can_create_comment(): void
    {
        $post = Post::factory()->create();

        $this->post(route('comments.store', $post), [
            'guest_name' => 'Guest User',
            'comment' => 'This is a guest comment.',
        ])->assertRedirect(route('posts.show', $post));

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => null,
            'guest_name' => 'Guest User',
            'comment' => 'This is a guest comment.',
        ]);
    }

    public function test_authenticated_user_can_create_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user)
            ->post(route('comments.store', $post), [
                'comment' => 'My comment.',
            ])->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => 'My comment.',
        ]);
    }

    public function test_guest_name_is_required_for_guest(): void
    {
        $post = Post::factory()->create();

        $this->post(route('comments.store', $post), [
            'comment' => 'A comment without a name.',
        ])->assertSessionHasErrors('guest_name');

        $this->assertDatabaseCount('comments', 0);
    }

    public function test_comment_author_can_delete_own_comment(): void
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->delete(route('comments.destroy', $comment))
            ->assertRedirect();

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_post_author_can_delete_comment(): void
    {
        $postAuthor = User::factory()->create();

        $post = Post::factory()->create([
            'user_id' => $postAuthor->id,
        ]);

        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => null,
            'guest_name' => 'Guest User',
        ]);

        $this->actingAs($postAuthor)
            ->delete(route('comments.destroy', $comment))
            ->assertRedirect();

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_other_user_cannot_delete_comment(): void
    {
        $comment = Comment::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($otherUser)
            ->delete(route('comments.destroy', $comment))
            ->assertForbidden();

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_guest_cannot_delete_comment(): void
    {
        $comment = Comment::factory()->create();

        $this->delete(route('comments.destroy', $comment))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
        ]);
    }
}
