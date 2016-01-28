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
     * @param string $sort      Sort result by this property
     * @param string $direction Sort order (see constants)
     *
     * @return EntityList|EntityInterface[]
     */
    public function findAll($sort = '', $direction = '');

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
     * @param Query  $query     A property query from the QueryBuilder
     * @param string $sort      Sort result by given property
     * @param string $direction Sort order
     *
     * @return EntityList|EntityInterface[]
     */
    public function findBy(Query $query, $sort = '', $direction = '');
}
