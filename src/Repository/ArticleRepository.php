<?php

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\Entity\Article;
use Terminal42\WeblingApi\EntityList;
use Terminal42\WeblingApi\Query\Query;

/**
 * @method EntityList|Article[] findAll($sort = '', $direction = '')
 * @method Article              findById($id)
 * @method EntityList|Article[] findBy(Query $query = null, $sort = '', $direction = '')
 */
class ArticleRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'article';
    }
}
