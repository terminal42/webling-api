<?php

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\Entity\Membergroup;
use Terminal42\WeblingApi\EntityList;

/**
 * @method EntityList|Membergroup[] findAll($sort = '', $direction = '')
 * @method Membergroup findById($id)
 */
class MembergroupRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'membergroup';
    }
}
