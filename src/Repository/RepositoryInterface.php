<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\Entity\EntityInterface;
use Terminal42\WeblingApi\EntityList;
use Terminal42\WeblingApi\Query\Query;

interface RepositoryInterface
{
    public const DIRECTION_ASC = 'ASC';
    public const DIRECTION_DESC = 'DESC';

    /**
     * Gets the entity type for this repository.
     */
    public function getType(): string;

    /**
     * Finds all entities of this type.
     *
     * @param array $order a sorting array where key is property and value is direction (see constants)
     *
     * @return EntityList|EntityInterface[]
     */
    public function findAll(array $order = []): EntityList;

    /**
     * Find entity by ID.
     *
     * @param int $id The entity ID
     */
    public function findById(int $id): EntityInterface;

    /**
     * Find entities with given properties.
     *
     * @param Query $query A property query from the QueryBuilder
     * @param array $order a sorting array where key is property and value is direction (see constants)
     *
     * @return EntityList|EntityInterface[]
     */
    public function findBy(Query $query, array $order = []): EntityList;
}
