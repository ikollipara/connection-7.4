<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * test that a post can be created
     */
    public function test_a_post_can_be_created()
    {
        $post = Post::factory()->make();
        $this->assertDatabaseCount('posts', 0);
        $post->save();
        $this->assertDatabaseCount('posts', 1);
    }

    /**
     * test that a post has a generated slug.
     */
    public function test_a_post_has_a_generated_slug()
    {
        $post = Post::factory()->create();
        $this->assertNotNull($post->slug);
    }

    /**
     * test that a post's slug regenerates if its not published
     */
    public function test_a_post_slug_regenerates_if_its_not_published()
    {
        $post = Post::factory()->create(['published' => false]);
        $slug = $post->slug;
        $post->title = $this->faker->word();
        $post->save();
        $this->assertNotEquals($slug, $post->slug);
    }

    /**
     * test that a post's slug does not regnerate if it is already published
     */
    public function test_a_post_slug_does_not_regenerate_if_it_is_already_published()
    {
        $post = Post::factory()->create(['published' => true]);
        $slug = $post->slug;
        $post->title = $this->faker->word();
        $post->save();
        $this->assertEquals($slug, $post->slug);
    }

    /**
     * test that a post still exists if the user is deleted.
     */
    public function test_a_post_still_exists_if_the_user_is_deleted()
    {
        $post = Post::factory()->create();
        $this->assertDatabaseCount('posts', 1);
        $post->user->delete();
        $this->assertDatabaseCount('posts', 1);
    }

    /**
     * test a post can have comments
     */
    public function test_a_post_can_have_comments()
    {
        $post = Post::factory()->create();
        $this->assertDatabaseCount('comments', 0);
        $post->comments()->create(['body' => $this->faker->paragraphs(3, true)]);
        $this->assertDatabaseCount('comments', 1);
    }

    /**
     * Test that a post has a zero likes by default
     */
    public function test_a_post_has_a_zero_likes_by_default()
    {
        $post = Post::factory()->create();
        $this->assertEquals(0, $post->likes());
    }

    /**
     * Test that a post can be liked
     */
    public function test_a_post_can_be_liked()
    {
        $post = Post::factory()->create();
        $this->assertEquals(0, $post->likes());
        $post->like(User::factory()->create());
        $this->assertEquals(1, $post->likes());
    }

    /**
     * Test that a post can be unliked
     */
    public function test_a_post_can_be_disliked()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $this->assertEquals(0, $post->likes());
        $post->like($user);
        $this->assertEquals(1, $post->likes());
        $post->unlike($user);
        $this->assertEquals(0, $post->likes());
    }

    /**
     * Test that a post can be liked only once by a user
     */
    public function test_a_post_can_be_liked_only_once_by_a_user()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $this->assertEquals(0, $post->likes());
        $post->like($user);
        $this->assertEquals(1, $post->likes());
        $this->expectException(\Illuminate\Database\QueryException::class);
        $post->like($user);
        $this->assertEquals(1, $post->likes());
    }

    /**
     * Test that a post can be liked by multiple users
     */
    public function test_a_post_can_be_liked_by_multiple_users()
    {
        $post = Post::factory()->create();
        $this->assertEquals(0, $post->likes());
        $post->like(User::factory()->create());
        $this->assertEquals(1, $post->likes());
        $post->like(User::factory()->create());
        $this->assertEquals(2, $post->likes());
        $post->like(User::factory()->create());
        $this->assertEquals(3, $post->likes());
    }

    /**
     * Test isLikedBy
     */
    public function test_is_liked_by()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $this->assertFalse($post->isLikedBy($user));
        $post->like($user);
        $this->assertTrue($post->isLikedBy($user));
    }

    /**
     * Test that you can get a post by status
     */
    public function test_you_can_get_a_post_by_status()
    {
        $posts = Post::factory()
            ->count(3)
            ->state(new Sequence(
                ['published' => true,],
                ['published' => false,],
                ['published' => true,],
            ))
            ->create();

        $this->assertDatabaseCount('posts', 3);
        $this->assertEquals(2, Post::query()->status('published')->count());
        $this->assertEquals(1, Post::query()->status('draft')->count());
        $posts[0]->delete();
        $this->assertEquals(1, Post::query()->status('archived')->count());
    }
}
