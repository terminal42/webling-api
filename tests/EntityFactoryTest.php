<?php

namespace Terminal42\WeblingApi\Test;

use Terminal42\WeblingApi\EntityFactory;

class EntityFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testSupports()
    {
        $factory = new EntityFactory();

        static::assertTrue($factory->supports('member'));
        static::assertTrue($factory->supports('membergroup'));
        static::assertTrue($factory->supports('article'));
        static::assertTrue($factory->supports('articlegroup'));
        static::assertTrue($factory->supports('document'));
        static::assertTrue($factory->supports('documentgroup'));
        static::assertFalse($factory->supports('foo'));
    }
}
