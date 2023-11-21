<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class AuthedTestCase extends TestCase
{
  use RefreshDatabase, WithFaker;

  /**
   * @var User
   */
  protected $user; // declared $user property

  /**
   * Setup an authenticated user
   */
  public function setUp(): void
  {
    parent::setUp();
    $this->user = User::factory()->create(); // updated to use $user property
    $this->actingAs($this->user);
  }

  public function tearDown(): void
  {
    $this->user->delete();
    parent::tearDown();
  }
}
