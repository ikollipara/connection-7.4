<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\AuthedTestCase;

class HomeControllerTest extends AuthedTestCase
{
    /**
     * Test that the home page loads
     */
    public function test_the_home_page_loads()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    /**
     * Test that the home page renders the correct inertia template
     */
    public function test_the_home_page_renders_the_correct_inertia_template()
    {
        $response = $this->get(route('home'));
        $response->assertInertia(fn ($page) => $page->component('Home')->has('most_viewed_posts')->has('most_viewed_post_collections'));
    }
}
