<?php

namespace Terminal42\WeblingApi;

use Terminal42\WeblingApi\Entity\EntityInterface;

interface EntityFactoryInterface
{
    /**
     * Create an entity from given JSON data.
     *
     * @param EntityManager $manager
     * @param array         $data
     * @param int           $id
     *
     * @return EntityInterface
     */
    public function create(EntityManager $manager, array $data, $id = null);

    /**
     * Returns whether the factory supports an entity type.
     *
     * @param string $type The entity type
     *
     * @return bool
     */
    public function supports($type);
}
