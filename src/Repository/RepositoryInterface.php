<?php

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\Entity\EntityInterface;
use Terminal42\WeblingApi\EntityList;

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
     * @param array $properties A key-value list of properties and values
     * @param string $sort      Sort result by given property
     * @param string $direction Sort order
     *
     * @return EntityList|EntityInterface[]
     */
    public function findBy(array $properties, $sort = '', $direction = '');
}
