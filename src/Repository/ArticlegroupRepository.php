<?php

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\Entity\Articlegroup;
use Terminal42\WeblingApi\EntityList;
use Terminal42\WeblingApi\Query\Query;

/**
 * @method EntityList|Articlegroup[] findAll($sort = '', $direction = '')
 * @method Articlegroup              findById($id)
 * @method EntityList|Articlegroup[] findBy(Query $query = null, $sort = '', $direction = '')
 */
class ArticlegroupRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'articlegroup';
    }
}
