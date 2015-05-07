<?php

namespace Terminal42\WeblingApi\Test;

use Terminal42\WeblingApi\Entity\Member;
use Terminal42\WeblingApi\EntityFactory;
use Terminal42\WeblingApi\EntityManager;

class EntityManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testFindAllMembers()
    {
        $client  = $this->getMock('Terminal42\\WeblingApi\\ClientInterface');
        $manager = new EntityManager($client, new EntityFactory());

        $client
            ->expects($this->once())
            ->method('get')
            ->with('/member')
            ->willReturn(['objects' => [1,2,3]])
        ;

        $members = $manager->findAll('member');

        $this->assertInstanceOf('Terminal42\\WeblingApi\\EntityList', $members);
        $this->assertEquals([1, 2, 3], $members->getIds());
    }

    public function testFindMember()
    {
        $client  = $this->getMock('Terminal42\\WeblingApi\\ClientInterface');
        $factory = $this->getMock('Terminal42\WeblingApi\EntityFactoryInterface');
        $manager = new EntityManager($client, $factory);

        $client
            ->expects($this->once())
            ->method('get')
            ->with('/member/111')
            ->willReturn(['type' => 'member'])
        ;

        $factory
            ->expects($this->once())
            ->method('create')
            ->with($manager, ['type' => 'member'])
        ;

        $manager->find('member', 111);
    }

    public function testPersistWithId()
    {
        $client  = $this->getMock('Terminal42\\WeblingApi\\ClientInterface');
        $entity  = new Member(111);
        $manager = new EntityManager($client, new EntityFactory());

        $client
            ->expects($this->once())
            ->method('put')
            ->with('/member/111')
        ;

        $manager->persist($entity);
    }

    public function testPersistWithoutId()
    {
        $client  = $this->getMock('Terminal42\\WeblingApi\\ClientInterface');
        $entity  = new Member();
        $manager = new EntityManager($client, new EntityFactory());

        $client
            ->expects($this->once())
            ->method('post')
            ->willReturn(111)
        ;

        $manager->persist($entity);

        $this->assertEquals(111, $entity->getId());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPersistReadonly()
    {
        $client  = $this->getMock('Terminal42\\WeblingApi\\ClientInterface');
        $entity  = new Member(111, true);
        $manager = new EntityManager($client, new EntityFactory());

        $manager->persist($entity);
    }

    public function testRemove()
    {
        $client  = $this->getMock('Terminal42\\WeblingApi\\ClientInterface');
        $entity  = new Member(111);
        $manager = new EntityManager($client, new EntityFactory());

        $client
            ->expects($this->once())
            ->method('delete')
            ->with('/member/111')
        ;

        $manager->remove($entity);

        $this->assertEquals(null, $entity->getId());
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testRemoveWithoutId()
    {
        $client  = $this->getMock('Terminal42\\WeblingApi\\ClientInterface');
        $entity  = new Member();
        $manager = new EntityManager($client, new EntityFactory());

        $manager->remove($entity);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRemoveReadonly()
    {
        $client  = $this->getMock('Terminal42\\WeblingApi\\ClientInterface');
        $entity  = new Member(111, true);
        $manager = new EntityManager($client, new EntityFactory());

        $manager->remove($entity);
    }
}
