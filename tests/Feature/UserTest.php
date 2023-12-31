<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\PostCollection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * test that a user can be created
     */
    public function test_a_user_can_be_created()
    {
        $user = User::factory()->make();
        $this->assertDatabaseCount('users', 0);
        $user->save();
        $this->assertDatabaseCount('users', 1);
    }

    /**
     * test that a user can get a correct full name.
     */
    public function test_a_user_can_get_a_correct_full_name()
    {
        $user = User::factory()->create();
        $this->assertEquals($user->full_name(), $user->first_name . ' ' . $user->last_name);
    }

    /**
     * test that the user password is hashed
     */
    public function test_the_user_password_is_hashed()
    {
        $user = User::factory()->create(['password' => 'password']);
        $this->assertNotEquals($user->password, 'password');
        $this->assertTrue(Hash::check('password', $user->password));
    }

    /**
     * test that the user's email is normalized
     */
    public function test_the_user_email_is_normalized()
    {
        $email = Str::padBoth($this->faker->email(), $this->faker->numberBetween(1, 10), ' ');
        $user = User::factory()->create(['email' => $email]);
        $this->assertEquals($user->email, Str::of($email)->trim()->lower());
    }

    /**
     * test that the user's id is set after creation, and that the id is a valid uuid.
     */
    public function test_the_user_id_is_set_after_creation_and_is_a_valid_uuid()
    {
        $user = User::factory()->create();
        $this->assertNotNull($user->id);
        $this->assertTrue(Str::isUuid($user->id));
    }

    /**
     * Test that the user has posts
     */
    public function test_the_user_has_posts()
    {
        $user = User::factory()->create();
        $this->assertEmpty($user->posts);
        $post = Post::factory()->create(['user_id' => $user->id]);
        $user->refresh();
        $this->assertNotEmpty($user->posts);
    }

    /**
     * test that the user has post collections
     */
    public function test_the_user_has_post_collections()
    {
        $user = User::factory()->create();
        $this->assertEmpty($user->postCollections);
        $postCollection = PostCollection::factory()->create(['user_id' => $user->id]);
        $user->refresh();
        $this->assertNotEmpty($user->postCollections);
    }

    /**
     * Test that the user has comments
     */
    public function test_the_user_has_comments()
    {
        $user = User::factory()->create();
        $this->assertEmpty($user->comments);
        $post = Post::factory()->create(['user_id' => $user->id]);
        $post->comments()->create(['body' => $this->faker->paragraphs(3, true), 'user_id' => $user->id]);
        $user->refresh();
        $this->assertNotEmpty($user->comments);
    }
}
