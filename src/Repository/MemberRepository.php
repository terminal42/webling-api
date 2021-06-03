<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\Entity\Member;
use Terminal42\WeblingApi\EntityList;
use Terminal42\WeblingApi\Query\Query;

/**
 * @method EntityList|Member[] findAll(array $order = [])
 * @method Member              findById($id)
 * @method EntityList|Member[] findBy(Query $query, array $order = [])
 */
class MemberRepository extends AbstractRepository
{
    public function getType(): string
    {
        return 'member';
    }
}
