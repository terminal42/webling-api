<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Query;

class QueryBuilder
{
    /**
     * @param string $property
     *
     * @return Parameter
     */
    public function where($property)
    {
        $parameter = new Parameter($property);
        $group = new Query($parameter);

        $parameter->setParent($group);

        return $parameter;
    }

    public function group(Query $group): Query
    {
        $parentGroup = new Query($group);

        $group->setParent($parentGroup);

        return $parentGroup;
    }
}
