<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * test that a comment can get its user
     */
    public function test_a_comment_can_get_its_user()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $comment->user->id);
    }

    /**
     * test that a comment can get its commentable
     */
    public function test_a_comment_can_get_its_commentable()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'commentable_id' => $post->id,
            'commentable_type' => get_class($post)
        ]);

        $this->assertEquals($post->id, $comment->commentable->id);
    }
}
