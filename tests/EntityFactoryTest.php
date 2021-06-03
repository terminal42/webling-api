<?php

namespace Terminal42\WeblingApi\Test;

use PHPUnit\Framework\TestCase;
use Terminal42\WeblingApi\EntityFactory;

class EntityFactoryTest extends TestCase
{
    public function testSupports(): void
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
