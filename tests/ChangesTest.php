<?php

namespace Terminal42\WeblingApi\Test;

use PHPUnit\Framework\TestCase;
use Terminal42\WeblingApi\Changes;
use Terminal42\WeblingApi\EntityList;
use Terminal42\WeblingApi\EntityManager;

class ChangesTest extends TestCase
{
    /**
     * @var Changes
     */
    private $changes;

    protected function setUp(): void
    {
        $this->changes = new Changes(
            1,
            [
                'objects'      => [
                    'member'      => [
                        469,
                        492,
                    ],
                    'membergroup' => [
                        554,
                        552,
                    ],
                    'debitor'     => [
                        848,
                    ],
                ],
                'context'      => [],
                'definitions'  => [],
                'settings'     => false,
                'quota'        => true,
                'subscription' => false,
                'revision'     => 1530,
                'version'      => 720,
            ],
            $this->createMock(EntityManager::class)
        );
    }

    public function testGetAllEntities(): void
    {
        $entities = $this->changes->getAllEntities();

        foreach (['member', 'membergroup', 'debitor'] as $type) {
            $this->assertArrayHasKey($type, $entities);
            $this->assertInstanceOf(EntityList::class, $entities[$type]);
        }
    }

    public function testGetEntities(): void
    {
        $entities = $this->changes->getEntities('member');

        $this->assertInstanceOf(EntityList::class, $entities);
        $this->assertEquals([469,492], $entities->getIds());
    }
}
