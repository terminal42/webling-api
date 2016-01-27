<?php

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\Entity\Document;
use Terminal42\WeblingApi\EntityList;
use Terminal42\WeblingApi\Query\Query;

/**
 * @method EntityList|Document[] findAll($sort = '', $direction = '')
 * @method Document              findById($id)
 * @method EntityList|Document[] findBy(Query $query = null, $sort = '', $direction = '')
 */
class DocumentRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'document';
    }
}
