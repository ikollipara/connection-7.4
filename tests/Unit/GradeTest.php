<?php

namespace Tests\Unit;

use App\Enums\Grade;
use PHPUnit\Framework\TestCase;

class GradeTest extends TestCase
{
    /**
     * test that grade pairs are outputted correctly
     */
    public function test_grade_pairs_are_outputted_correctly()
    {
        $pairs = Grade::asPairs();
        $this->assertIsArray($pairs);
        $this->assertEquals($pairs[0], [Grade::Kindergarten, 'Kindergarten']);
    }
}
