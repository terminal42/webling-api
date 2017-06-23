<?php

namespace Terminal42\WeblingApi\Query;

class Query implements BuildableInterface
{
    /**
     * @var array
     */
    private $blocks = [];

    private $parent;

    /**
     * Constructor.
     *
     * @param Parameter|Query $block
     */
    public function __construct($block)
    {
        $this->blocks[] = $block;
    }

    /**
     * @param string $property
     *
     * @return Parameter
     */
    public function andWhere($property)
    {
        $parameter = new Parameter($property, $this);

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
        $parameter = new Parameter($property, $this);

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
        $blocks = array_map(
            function ($block) {
                if ($block instanceof BuildableInterface) {
                    return $block->build();
                }

                return (string) $block;
            },
            $this->blocks
        );

        if (null !== $this->parent) {
            return '(' . implode(' ', $blocks) . ')';
        }

        return implode(' ', $blocks);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->build();
    }
}
