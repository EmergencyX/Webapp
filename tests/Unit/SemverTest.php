<?php

namespace EmergencyExplorer\Rules;

use Tests\TestCase;

class SemverTest extends TestCase
{
    public function testPasses()
    {
        $validator = new Semver();
        $this->assertTrue($validator->passes('', '1.0.0'));
        $this->assertFalse($validator->passes('', 'a.b.c'));
    }
}
