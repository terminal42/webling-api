<?php

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\Entity\Membergroup;
use Terminal42\WeblingApi\EntityList;
use Terminal42\WeblingApi\Query\Query;

/**
 * @method EntityList|Membergroup[] findAll($sort = '', $direction = '')
 * @method Membergroup              findById($id)
 * @method EntityList|Membergroup[] findBy(Query $query = null, $sort = '', $direction = '')

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
