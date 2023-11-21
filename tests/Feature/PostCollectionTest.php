<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\PostCollection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostCollectionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * test that a post collection can be created
     */
    public function test_a_post_collection_can_be_created()
    {
        $postCollection = PostCollection::factory()->make();
        $this->assertDatabaseCount('post_collections', 0);
        $postCollection->save();
        $this->assertDatabaseCount('post_collections', 1);
    }

    /**
     * test that a post collection has a generated slug.
     */
    public function test_a_post_collection_has_a_generated_slug()
    {
        $postCollection = PostCollection::factory()->create();
        $this->assertNotNull($postCollection->slug);
    }

    /**
     * test that a post collection's slug regenerates if its not published
     */
    public function test_a_post_collection_slug_regenerates_if_its_not_published()
    {
        $postCollection = PostCollection::factory()->create(['published' => false]);
        $slug = $postCollection->slug;
        $postCollection->title = $this->faker->word();
        $postCollection->save();
        $this->assertNotEquals($slug, $postCollection->slug);
    }

    /**
     * test that a post collection's slug does not regnerate if it is already published
     */
    public function test_a_post_collection_slug_does_not_regenerate_if_it_is_already_published()
    {
        $postCollection = PostCollection::factory()->create(['published' => true]);
        $slug = $postCollection->slug;
        $postCollection->title = $this->faker->word();
        $postCollection->save();
        $this->assertEquals($slug, $postCollection->slug);
    }

    /**
     * test that a post collection still exists if the user is deleted.
     */
    public function test_a_post_collection_still_exists_if_the_user_is_deleted()
    {
        $postCollection = PostCollection::factory()->create();
        $postCollection->user->delete();
        $this->assertDatabaseCount('post_collections', 1);
    }

    /**
     * test that a post collection can have multiple posts
     */
    public function test_a_post_collection_can_have_multiple_posts()
    {
        $postCollection = PostCollection::factory()->create();
        $posts = Post::factory()->count(3)->create();
        $postCollection->posts()->attach($posts);
        $this->assertEquals($postCollection->posts()->count(), 3);
    }

    /**
     * Test that you can get a post by status
     */
    public function test_you_can_get_a_post_by_status()
    {
        $post_collection = PostCollection::factory()
            ->count(3)
            ->state(new Sequence(
                ['published' => true,],
                ['published' => false,],
                ['published' => true,],
            ))
            ->create();

        $this->assertDatabaseCount('post_collections', 3);
        $this->assertEquals(2, PostCollection::query()->status('published')->count());
        $this->assertEquals(1, PostCollection::query()->status('draft')->count());
        $post_collection[0]->delete();
        $this->assertEquals(1, PostCollection::query()->status('archived')->count());
        $this->assertEquals(PostCollection::query()->count(), PostCollection::query()->status('')->count());
    }
}
