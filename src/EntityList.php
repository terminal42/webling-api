<?php

namespace Terminal42\WeblingApi;

use Terminal42\WeblingApi\Entity\EntityInterface;

class EntityList implements \Iterator, \Countable
{
    private $type;
    private $ids;
    private $manager;

    public function __construct($type, array $ids, EntityManager $manager)
    {
        $this->type    = $type;
        $this->ids     = $ids;
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->manager->find($this->type, current($this->ids));
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        next($this->ids);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return current($this->ids);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return (false !== current($this->ids));
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        reset($this->ids);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->ids);
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
     *
     * @param EntityInterface $entity
     *
     * @return $this
     */
    public function add(EntityInterface $entity)
    {
        if ($this->type !== $entity->getType()) {
            throw new \InvalidArgumentException('Entity type does not match entity list.');
        }

        $id = $entity->getId();

        if (null === $id) {
            throw new \InvalidArgumentException('The entity must have an ID.');
        }

        if (!in_array($id, $this->ids)) {
            $this->ids[] = $id;
        }

        return $this;
    }
}
