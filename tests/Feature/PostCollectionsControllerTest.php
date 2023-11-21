<?php

namespace Tests\Feature;

use App\Models\PostCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\AuthedTestCase;

class PostCollectionsControllerTest extends AuthedTestCase
{
    /**
     * Test that the post collections index page loads
     */
    public function test_the_post_collections_index_page_loads()
    {
        $response = $this->get(route('collections.index'));
        $response->assertStatus(200);
    }

    /**
     * Test that the post collections index page renders the correct inertia template
     */
    public function test_the_post_collections_index_page_renders_the_correct_inertia_template()
    {
        $response = $this->get(route('collections.index'));
        $response->assertInertia(fn ($page) => $page->component('PostCollections/Index')->has('collections'));
    }

    /**
     * Test that the post collections create page loads
     */
    public function test_the_post_collections_create_page_loads()
    {
        $response = $this->get(route('collections.create'));
        $response->assertStatus(200);
    }

    /**
     * Test that the post collections create page renders the correct inertia template
     */
    public function test_the_post_collections_create_page_renders_the_correct_inertia_template()
    {
        $response = $this->get(route('collections.create'));
        $response->assertInertia(fn ($page) => $page->component('PostCollections/Create'));
    }

    /**
     * Test that the post collections show page loads
     */
    public function test_the_post_collections_show_page_loads()
    {
        $collection = $this->user->postCollections()->create([
            'title' => $this->faker->sentence(3),
        ]);
        $response = $this->get(route('collections.show', ['post_collection' => $collection]));
        $response->assertStatus(200);
    }

    /**
     * Test that the post collections show page renders the correct inertia template
     */
    public function test_the_post_collections_show_page_renders_the_correct_inertia_template()
    {
        $collection = $this->user->postCollections()->create([
            'title' => $this->faker->sentence(3),
        ]);
        $response = $this->get(route('collections.show', ['post_collection' => $collection]));
        $response->assertInertia(fn ($page) => $page->component('PostCollections/Show')->has('collection')->has('likes'));
    }

    /**
     * Test that the post collections edit page loads
     */
    public function test_the_post_collections_edit_page_loads()
    {
        $collection = $this->user->postCollections()->create([
            'title' => $this->faker->sentence(3),
        ]);
        $response = $this->get(route('collections.edit', ['post_collection' => $collection]));
        $response->assertStatus(200);
    }

    /**
     * Test that the post collections edit page renders the correct inertia template
     */
    public function test_the_post_collections_edit_page_renders_the_correct_inertia_template()
    {
        $collection = $this->user->postCollections()->create([
            'title' => $this->faker->sentence(3),
        ]);
        $response = $this->get(route('collections.edit', ['post_collection' => $collection]));
        $response->assertInertia(fn ($page) => $page->component('PostCollections/Edit')->has('collection'));
    }

    /**
     * Test that a post collection can be created
     */
    public function test_a_post_collection_can_be_created()
    {
        $collection = PostCollection::factory()->make(['user_id' => $this->user->id])->toArray();
        $response = $this->post(route('collections.store'), array_merge($collection, [
            'body' => json_encode($collection['body']),
            'metadata' => json_encode($collection['metadata'])
        ]));
        $this->user->refresh();
        $response->assertRedirect(route('collections.edit', ['post_collection' => $this->user->postCollections()->first()]));
    }

    /**
     * Test that a post collection can be updated
     */
    public function test_a_post_collection_can_be_updated()
    {
        $collection = PostCollection::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $this->user->refresh();
        $response = $this->put(route('collections.update', ['post_collection' => $collection]), array_merge($collection->toArray(), [
            'title' => $this->faker->sentence(3),
            'body' => json_encode($collection['body']),
            'metadata' => json_encode($collection['metadata'])
        ]));
        $this->user->refresh();
        $response->assertRedirect(route('collections.edit', ['post_collection' => $collection]));
    }

    /**
     * Test that a post collection can be deleted
     */
    public function test_a_post_collection_can_be_deleted()
    {
        $collection = $this->user->postCollections()->create([
            'title' => $this->faker->sentence(3),
        ]);
        $this->user->refresh();
        $response = $this->delete(route('collections.destroy', ['post_collection' => $collection]));
        $response->assertRedirect(route('collections.index', ['status' => 'draft']));
    }

    /**
     * Test that a post collection can be restored
     */
    public function test_a_post_collection_can_be_restored()
    {
        $collection = $this->user->postCollections()->create([
            'title' => $this->faker->sentence(3),
        ]);
        $collection->delete();
        $response = $this->patch(route('collections.restore', ['post_collection' => $collection]));
        $response->assertRedirect(route('collections.index'));
    }
}
