<?php

namespace Terminal42\WeblingApi\Query;

class Query
{
    /**
     * @var array
     */
    private $blocks = [];

    private $parent;

    /**
     * Constructor.
     */
    public function __construct($parameterOrGroup)
    {
        $this->blocks[] = $parameterOrGroup;
    }

    /**
     * @param string $property
     *
     * @return Parameter
     */
    public function andWhere($property)
    {
        $parameter = new Parameter($property);
        $parameter->setParent($this);

        $this->blocks[] = 'AND';
        $this->blocks[] = $parameter;

        return $parameter;
    }

    /**
     * @param string $property
     *
     * @return Parameter
     */
    public function orWhere($property)
    {
        $parameter = new Parameter($property);
        $parameter->setParent($this);

        $this->blocks[] = 'OR';
        $this->blocks[] = $parameter;

        return $parameter;
    }

    public function andGroup(Query $group)
    {
        $this->blocks[] = 'AND';
        $this->blocks[] = $group;

        $group->setParent($this);

        return $this;
    }

    public function orGroup(Query $group)
    {
        $this->blocks[] = 'OR';
        $this->blocks[] = $group;

        $group->setParent($this);

        return $this;
    }

    public function setParent(Query $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function build()
    {
        if (null !== $this->parent) {
            return '(' . implode(' ', $this->blocks) . ')';
        }

        return implode(' ', $this->blocks);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->build();
    }
}
