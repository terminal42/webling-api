<?php

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
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'member';
    }
}
