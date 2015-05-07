<?php

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\EntityManager;

abstract class AbstractRepository implements RepositoryInterface
{
    protected $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll($sort = '', $direction = '')
    {
        return $this->manager->findAll($this->getType(), '', $sort, $direction);
    }

    /**
     * {@inheritdoc}
     */
    public function findById($id)
    {
        return $this->manager->find($this->getType(), $id);
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $properties, $sort = '', $direction = '')
    {
        $entities = $this->manager->findAll($this->getType(), '', $sort, $direction);

        return new PropertyFilter($entities, $properties);
    }
}
