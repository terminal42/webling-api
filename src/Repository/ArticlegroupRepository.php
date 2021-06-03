<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\Entity\Articlegroup;
use Terminal42\WeblingApi\EntityList;
use Terminal42\WeblingApi\Query\Query;

/**
 * @method EntityList|Articlegroup[] findAll(array $order = [])
 * @method Articlegroup              findById($id)
 * @method EntityList|Articlegroup[] findBy(Query $query, array $order = [])
 */
class ArticlegroupRepository extends AbstractRepository
{
    public function getType(): string
    {
        return 'articlegroup';
    }
}
