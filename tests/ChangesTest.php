<?php

namespace Terminal42\WeblingApi\Test;

use Terminal42\WeblingApi\Changes;

class ChangesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Changes
     */
    private $changes;

    protected function setUp()
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
            $this->getMock('Terminal42\\WeblingApi\\EntityManager', [], [], '', false)
        );
    }

    public function testGetAllEntities()
    {
        $entities = $this->changes->getAllEntities();

        foreach (['member', 'membergroup', 'debitor'] as $type) {
            $this->assertArrayHasKey($type, $entities);
            $this->assertInstanceOf('Terminal42\WeblingApi\EntityList', $entities[$type]);
        }
    }

    public function testGetEntities()
    {
        $entities = $this->changes->getEntities('member');

        $this->assertInstanceOf('Terminal42\WeblingApi\EntityList', $entities);
        $this->assertEquals([469,492], $entities->getIds());
    }
}
