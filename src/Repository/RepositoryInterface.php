<?php

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\Entity\EntityInterface;
use Terminal42\WeblingApi\EntityList;
use Terminal42\WeblingApi\Query\Query;

interface RepositoryInterface
{
    const DIRECTION_ASC  = 'ASC';
    const DIRECTION_DESC = 'DESC';

    /**
     * Gets the entity type for this repository.
     *
     * @return string
     */
    public function getType();

    /**
     * Finds all entities of this type.
     *
     * @param array $order A sorting array where key is property and value is direction (see constants).
     *
     * @return EntityList|EntityInterface[]
     */
    public function findAll(array $order = []);

    /**
     * Find entity by ID.
     *
     * @param int $id The entity ID
     *
     * @return EntityInterface
     */
    public function findById($id);

    /**
     * Find entities with given properties.
     *
     * @param Query $query A property query from the QueryBuilder
     * @param array $order A sorting array where key is property and value is direction (see constants).
     *
     * @return EntityList|EntityInterface[]
     */
    public function findBy(Query $query, array $order = []);
}
