<?php

namespace Tests\Unit;

use App\Models\Post;
use PHPUnit\Framework\TestCase;

class HasUuidsTest extends TestCase
{
    /**
     * Test Uuid getPrimaryType and getIncrementing
     */
    public function test_uuid_get_primary_type_and_get_incrementing()
    {
        $this->assertEquals('string', (new Post)->getKeyType());
        $this->assertFalse((new Post)->getIncrementing());
    }
}
