<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\PostCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\AuthedTestCase;

class CommentsControllerTest extends AuthedTestCase
{

    /**
     * Test the index method.
     */
    public function test_index()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $this->withoutExceptionHandling();
        $this->get(route('posts.comments.index', ['post' => $post]))
            ->assertStatus(200)
            ->assertInertia(
                fn ($assert) => $assert
                    ->component('Comments/Index')
                    ->has('comments')
                    ->has('commentable')
            );
    }

    /**
     * Test the store method with a post collection.
     */
    public function test_store_with_post_collection()
    {
        $post_collection = PostCollection::factory()->create(['user_id' => $this->user->id]);
        $this->withoutExceptionHandling();
        $this->post(route('collections.comments.store', [
            'post_collection' => $post_collection,
        ]), [
            'body' => 'This is a comment',
        ])
            ->assertStatus(302)
            ->assertRedirect(route('collections.comments.index', [
                'post_collection' => $post_collection,
            ]))
            ->assertSessionHas('success', 'Comment created successfully!');
    }

    /**
     * Test the store method.
     */
    public function test_store()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $this->withoutExceptionHandling();
        $this->post(route('posts.comments.store', ['post' => $post]), [
            'body' => 'This is a comment',
        ])
            ->assertStatus(302)
            ->assertRedirect(route('posts.comments.index', ['post' => $post]))
            ->assertSessionHas('success', 'Comment created successfully!');
    }

    /**
     * Test the update method.
     */
    public function test_update()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $comment = $post->comments()->create([
            'body' => 'This is a comment',
            'user_id' => $this->user->id,
        ]);
        $this->withoutExceptionHandling();
        $this->patch(route('posts.comments.update', [
            'post' => $post,
            'comment' => $comment,
        ]), [
            'body' => 'This is an updated comment',
        ])
            ->assertStatus(302)
            ->assertRedirect(route('posts.comments.index', ['post' => $post]))
            ->assertSessionHas('success', 'Comment updated successfully!');
    }
}
