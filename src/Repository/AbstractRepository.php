<?php

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\EntityManager;

abstract class AbstractRepository implements RepositoryInterface
{
    protected $manager;

    /**
     * Constructor.
     *
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws ParseException      If the JSON data could not be parsed
     */
    public function findAll($sort = '', $direction = '')
    {
        return $this->manager->findAll($this->getType(), '', $sort, $direction);
    }

    /**
     * {@inheritdoc}
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws ParseException      If the JSON data could not be parsed
     */
    public function findById($id)
    {
        return $this->manager->find($this->getType(), $id);
    }

    /**
     * {@inheritdoc}
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws ParseException      If the JSON data could not be parsed
     */
    public function findBy(array $properties, $sort = '', $direction = '')
    {
        $entities = $this->manager->findAll($this->getType(), '', $sort, $direction);

        return new PropertyFilter($entities, $properties);
    }
}
