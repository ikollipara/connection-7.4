<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\AuthedTestCase;

class UsersControllerTest extends AuthedTestCase
{
    /**
     * Test the show method.
     */
    public function test_show()
    {
        $this->withoutExceptionHandling();
        $this->get(route('users.show', ['user' => $this->user]))
            ->assertStatus(200)
            ->assertInertia(
                fn ($assert) => $assert
                    ->component('Users/Show')
                    ->has('user')
            );
    }

    /**
     * Test the edit method.
     */
    public function test_edit()
    {
        $this->withoutExceptionHandling();
        $this->get(route('users.edit', ['user' => $this->user]))
            ->assertStatus(200)
            ->assertInertia(
                fn ($assert) => $assert
                    ->component('Users/Edit')
                    ->has('user')
            );
    }

    /**
     * Test the update method.
     */
    public function test_update()
    {
        $this->withoutExceptionHandling();
        $this->put(route('users.update', ['user' => $this->user]), [
            'email' => $this->faker->email(),
        ])
            ->assertStatus(303)
            ->assertRedirect(route('users.show', ['user' => $this->user]))
            ->assertSessionHas('success', 'Profile updated successfully!');
    }

    /**
     * Test the destroy method.
     */
    public function test_destroy()
    {
        $this->withoutExceptionHandling();
        $this->delete(route('users.destroy', ['user' => $this->user]))
            ->assertStatus(303)
            ->assertRedirect(route('index'));
    }
}
