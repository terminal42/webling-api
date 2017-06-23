<?php

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\EntityManager;
use Terminal42\WeblingApi\Exception\HttpStatusException;
use Terminal42\WeblingApi\Exception\ParseException;
use Terminal42\WeblingApi\Query\Query;

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
    public function findAll(array $order = [])
    {
        return $this->manager->findAll($this->getType(), null, $order);
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
    public function findBy(Query $query, array $order = [])
    {
        return $this->manager->findAll($this->getType(), $query, $order);
    }
}
