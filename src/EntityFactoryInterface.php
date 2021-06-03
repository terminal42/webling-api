<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi;

use Terminal42\WeblingApi\Entity\EntityInterface;

interface EntityFactoryInterface
{
    /**
     * Create an entity from given JSON data.
     */
    public function create(EntityManager $manager, array $data, int $id = null): EntityInterface;

    /**
     * Returns whether the factory supports an entity type.
     */
    public function supports(string $type): bool;
}
