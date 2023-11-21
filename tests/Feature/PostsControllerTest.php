<?php

namespace Tests\Feature;

use App\Models\Post;
use Mockery;
use Tests\AuthedTestCase;


class PostsControllerTest extends AuthedTestCase
{

    /**
     * Test that the posts index page loads
     */
    public function test_the_posts_index_page_loads()
    {
        $response = $this->get(route('posts.index'));
        $response->assertStatus(200);
    }

    /**
     * Test that the posts index page renders the correct inertia template
     */
    public function test_the_posts_index_page_renders_the_correct_inertia_template()
    {
        $response = $this->get(route('posts.index'));
        $response->assertInertia(fn ($page) => $page->component('Posts/Index')->has('posts')->has('status'));
    }

    /**
     * Test that the posts create page loads
     */
    public function test_the_posts_create_page_loads()
    {
        $response = $this->get(route('posts.create'));
        $response->assertStatus(200);
    }

    /**
     * Test that the show page loads
     */
    public function test_the_posts_show_page_loads()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $response = $this->get(route('posts.show', ['post' => $post]));
        $response->assertStatus(200);
    }

    /**
     * Test that the show page renders the correct inertia template
     */
    public function test_the_posts_show_page_renders_the_correct_inertia_template()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $response = $this->get(route('posts.show', ['post' => $post]));
        $response->assertInertia(fn ($page) => $page->component('Posts/Show')->has('post')->has('likes'));
    }

    /**
     * Test that the edit page loads
     */
    public function test_the_posts_edit_page_loads()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $response = $this->get(route('posts.edit', ['post' => $post]));
        $response->assertStatus(200);
    }

    /**
     * Test that the edit page renders the correct inertia template
     */
    public function test_the_posts_edit_page_renders_the_correct_inertia_template()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $response = $this->get(route('posts.edit', ['post' => $post]));
        $response->assertInertia(fn ($page) => $page->component('Posts/Edit')->has('post'));
    }

    /**
     * Test that the edit page is not accessible to users who do not own the post
     */
    public function test_the_posts_edit_page_is_not_accessible_to_users_who_do_not_own_the_post()
    {
        $post = Post::factory()->create();
        $response = $this->get(route('posts.edit', ['post' => $post]));
        $response->assertStatus(403);
    }

    /**
     * test that a post can be created
     */
    public function test_a_post_can_be_created()
    {

        $post = Post::factory()->make(['user_id' => $this->user->id])->toArray();
        $response = $this->post(
            route('posts.store'),
            array_merge($post, [
                'metadata' => json_encode($post['metadata']),
                'body' => json_encode($post['body'])
            ])
        );
        $response->assertRedirect(route('posts.edit', ['post' => Post::query()->first()]));
        $response->assertSessionHas('success', 'Post created successfully!');
        $this->assertDatabaseCount('posts', 1);
    }

    /**
     * test that a post can be updated
     */
    public function test_a_post_can_be_updated()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $response = $this->put(
            route('posts.update', ['post' => $post]),
            array_merge($post->toArray(), [
                'metadata' => json_encode($post->metadata),
                'body' => json_encode($post->body)
            ])
        );
        $response->assertRedirect(route('posts.edit', ['post' => $post]));
        $response->assertSessionHas('success', 'Post updated successfully!');
    }

    /**
     * Test that a post can be archived
     */
    public function test_a_post_can_be_archived()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $response = $this->delete(route('posts.destroy', ['post' => $post]));
        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success', 'Post archived successfully!');
    }

    /**
     * Test that an archived post can be restored
     */
    public function test_an_archived_post_can_be_restored()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $post->delete();
        $response = $this->patch(route('posts.restore', ['post' => $post]));
        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success', 'Post restored successfully!');
    }
}
