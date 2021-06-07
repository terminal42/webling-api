<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi;

use Terminal42\WeblingApi\Entity\EntityInterface;

class EntityList implements \Iterator, \Countable, \JsonSerializable
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $ids;

    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * Constructor.
     *
     * @param string        $type    The entity type
     * @param array         $ids     An array of entity IDs
     * @param EntityManager $manager An entity manager to fetch entities
     */
    public function __construct(string $type, array $ids, EntityManager $manager)
    {
        $this->type = $type;
        $this->ids = $ids;
        $this->manager = $manager;
    }

    public function current()
    {
        return $this->manager->find($this->type, current($this->ids));
    }

    public function next(): void
    {
        next($this->ids);
    }

    public function key()
    {
        return current($this->ids);
    }

    public function valid(): bool
    {
        return false !== current($this->ids);
    }

    public function rewind(): void
    {
        reset($this->ids);
    }

    public function count(): int
    {
        return \count($this->ids);
    }

    /**
     * Gets all IDs of the entity list.
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * Adds an entity to the list.
     */
    public function add(EntityInterface $entity): self
    {
        if ($this->type !== $entity->getType()) {
            throw new \InvalidArgumentException('Entity type does not match entity list.');
        }

        $id = $entity->getId();

        if (null === $id) {
            throw new \InvalidArgumentException('The entity must have an ID.');
        }

        if (!\in_array($id, $this->ids, false)) {
            $this->ids[] = $id;
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return $this->ids;
    }
}
