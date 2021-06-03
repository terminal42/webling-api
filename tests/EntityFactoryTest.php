<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Test;

use PHPUnit\Framework\TestCase;
use Terminal42\WeblingApi\EntityFactory;

class EntityFactoryTest extends TestCase
{
    public function testSupports(): void
    {
        $factory = new EntityFactory();

        $this->assertTrue($factory->supports('member'));
        $this->assertTrue($factory->supports('membergroup'));
        $this->assertTrue($factory->supports('article'));
        $this->assertTrue($factory->supports('articlegroup'));
        $this->assertTrue($factory->supports('document'));
        $this->assertTrue($factory->supports('documentgroup'));
        $this->assertFalse($factory->supports('foo'));
    }
}
