<?php

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
        $group     = new Query($parameter);

        $parameter->setParent($group);

        return $parameter;
    }

    /**
     * @param Query $group
     *
     * @return Query
     */
    public function group(Query $group)
    {
        $parentGroup = new Query($group);

        $group->setParent($parentGroup);

        return $parentGroup;
    }
}
