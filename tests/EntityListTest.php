<?php

namespace Terminal42\WeblingApi\Test;

use Terminal42\WeblingApi\EntityList;

class EntityListTest extends \PHPUnit_Framework_TestCase
{

    public function testGetIds()
    {
        $manager = $this->getMock('Terminal42\\WeblingApi\\EntityManager', [], [], '', false);
        $list    = new EntityList('member', [1,2,3], $manager);

        $this->assertEquals([1,2,3], $list->getIds());
    }

    public function testFindInManager()
    {
        $manager = $this->getMock('Terminal42\\WeblingApi\\EntityManager', ['find'], [], '', false);
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
