<?php

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\Entity\Document;
use Terminal42\WeblingApi\EntityList;
use Terminal42\WeblingApi\Query\Query;

/**
 * @method EntityList|Document[] findAll(array $order = [])
 * @method Document              findById($id)
 * @method EntityList|Document[] findBy(Query $query, array $order = [])
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
