<?php

namespace Terminal42\WeblingApi\Test;

use Terminal42\WeblingApi\EntityFactory;

class EntityFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testSupports()
    {
        $factory = new EntityFactory();

        $this->assertTrue($factory->supports('member'));
        $this->assertTrue($factory->supports('membergroup'));
        $this->assertFalse($factory->supports('foo'));
    }

    public function testCreate()
    {
        $this->markTestIncomplete();
    }
}
