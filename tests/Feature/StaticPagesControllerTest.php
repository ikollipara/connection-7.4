<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class StaticPagesControllerTest extends TestCase
{
    use WithFaker;

    /**
     * test that the index page loads
     */
    public function test_the_index_page_loads()
    {
        $response = $this->get(route('index'));
        $response->assertStatus(200);
    }

    /**
     * test that the index page renders the correct
     * inertia template
     */
    public function test_the_index_page_renders_the_correct_inertia_template()
    {
        $response = $this->get(route('index'));
        $response->assertInertia(fn (Assert $page) => $page->component('Home'));
    }

    /**
     * test that the index page renders a guest navbar.
     */
    public function test_the_index_page_renders_a_guest_navbar()
    {
        $response = $this->get(route('index'));
        $response->assertInertia(fn (Assert $page) => $page->missing('user'));
    }

    /**
     * test that the about page loads.
     */
    public function test_the_about_page_loads()
    {
        $response = $this->get(route('about'));
        $response->assertStatus(200);
    }

    /**
     * test that the about page renders the correct inertia template.
     */
    public function test_the_about_page_renders_the_correct_inertia_template()
    {
        $response = $this->get(route('about'));
        $response->assertInertia(fn (Assert $page) => $page->component('About'));
    }

    /**
     * test that the about page renders a guest navbar.
     */
    public function test_the_about_page_renders_a_guest_navbar()
    {
        $response = $this->get(route('about'));
        $response->assertInertia(fn (Assert $page) => $page->missing('user'));
    }
}
