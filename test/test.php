<?php

use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testTrueEqualTrueTest() {
        $this->assertEquals(true, true);
    }

    public function testTrueNotEqualFalseTest() {
        $this->assertNotEquals(true, false);
    }
}