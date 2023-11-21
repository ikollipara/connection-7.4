<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * test that the registration page loads.
     */
    public function test_the_registration_page_loads()
    {
        $response = $this->get(route('registration.create'));
        $response->assertStatus(200);
    }

    /**
     * test that the registration page renders the correct inertia template.
     */
    public function test_the_registration_page_renders_the_correct_inertia_template()
    {
        $response = $this->get(route('registration.create'));
        $response->assertInertia(fn (Assert $page) => $page->component('Registration/Create'));
    }

    /**
     * test that registration page is not accessible to authenticated users.
     */
    public function test_the_registration_page_is_not_accessible_to_authenticated_users()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('registration.create'));
        $response->assertRedirect(route('home'));
    }


    /**
     * test that a use can be registered.
     */
    public function test_a_user_can_be_registered()
    {
        Storage::fake('avatars');
        $avatar = UploadedFile::fake()->image('avatar.jpg', 400, 400);

        $user = User::factory()
            ->make()->toArray();
        $user['password'] = $this->faker->password(12, 50);
        $user['password_confirmation'] = $user['password'];
        $response = $this->post(route('registration.store'), array_merge($user, [
            'bio' => json_encode($user['bio']),
            'avatar' => $avatar
        ]));
        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
    }
}
