<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\Entity\Article;
use Terminal42\WeblingApi\EntityList;
use Terminal42\WeblingApi\Query\Query;

/**
 * @method EntityList|Article[] findAll(array $order = [])
 * @method Article              findById($id)
 * @method EntityList|Article[] findBy(Query $query, array $order = [])
 */
class ArticleRepository extends AbstractRepository
{
    public function getType(): string
    {
        return 'article';
    }
}
