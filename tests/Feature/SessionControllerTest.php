<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * test that the login page loads.
     */
    public function test_the_login_page_loads()
    {
        $response = $this->get(URL::route('login.create'));
        $response->assertStatus(200);
    }

    /**
     * test that the login page renders the correct inertia template.
     */
    public function test_the_login_page_renders_the_correct_inertia_template()
    {
        $response = $this->get(URL::route('login.create'));
        $response->assertInertia(fn ($page) => $page->component('Sessions/Create'));
    }

    /**
     * test that login page is not accessible to authenticated users.
     */
    public function test_the_login_page_is_not_accessible_to_authenticated_users()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(URL::route('login.create'));
        $response->assertRedirect(URL::route('home'));
    }

    /**
     * test that a user can login
     */
    public function test_a_user_can_login()
    {
        $user = User::factory()->create(['password' => 'password'])
            ->toArray();
        $user['password'] = 'password';
        $response = $this->post(URL::route('login.store'), ['email' => $user['email'], 'password' => $user['password']]);
        $response->assertRedirect(URL::route('home'));
    }

    /**
     * test that a user can logout
     */
    public function test_a_user_can_logout()
    {
        $user = User::factory()->create(['password' => 'password'])
            ->toArray();
        $user['password'] = 'password';
        $response = $this->post(URL::route('login.store'), ['email' => $user['email'], 'password' => $user['password']]);
        $response->assertRedirect(URL::route('home'));
        $response = $this->delete(URL::route('logout'));
        $response->assertRedirect(URL::route('index'));
    }

    /**
     * test that the session contains errors if login failed
     */
    public function test_the_session_contains_errors_if_login_failed()
    {
        $user = User::factory()->create(['password' => 'password'])
            ->toArray();
        $user['password'] = 'wrong_password';
        $response = $this->post(URL::route('login.store'), ['email' => $user['email'], 'password' => $user['password']]);
        $response->assertSessionHasErrors();
    }
}
