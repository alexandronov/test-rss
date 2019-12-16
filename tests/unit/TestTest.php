<?php

namespace App\Tests\Unit;

class TestTest extends \Codeception\Test\Unit
{
    public function testFirstTest()
    {
        $foo = 'foo';

        $this->assertEquals('foo' , $foo);
    }
}
