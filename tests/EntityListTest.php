<?php

namespace Terminal42\WeblingApi\Test;

use PHPUnit\Framework\TestCase;
use Terminal42\WeblingApi\EntityList;
use Terminal42\WeblingApi\EntityManager;

class EntityListTest extends TestCase
{
    public function testGetIds(): void
    {
        $manager = $this->createMock(EntityManager::class);
        $list    = new EntityList('member', [1,2,3], $manager);

        $this->assertEquals([1,2,3], $list->getIds());
    }

    public function testFindInManager(): void
    {
        $manager = $this->createMock(EntityManager::class);
        $list    = new EntityList('member', [111], $manager);

        $manager
            ->expects($this->once())
            ->method('find')
            ->with('member', 111)
            ->willReturn('foo')
        ;

        $this->assertEquals('foo', $list->current());
    }
}
