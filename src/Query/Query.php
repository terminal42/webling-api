<?php

declare(strict_types=1);

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

    public function __toString(): string
    {
        return $this->build();
    }

    public function andWhere(string $property): Parameter
    {
        $parameter = new Parameter($property, $this);

        $this->blocks[] = 'AND';
        $this->blocks[] = $parameter;

        return $parameter;
    }

    public function orWhere(string $property): Parameter
    {
        $parameter = new Parameter($property, $this);

        $this->blocks[] = 'OR';
        $this->blocks[] = $parameter;

        return $parameter;
    }

    public function andGroup(self $group): self
    {
        $this->blocks[] = 'AND';
        $this->blocks[] = $group;

        $group->setParent($this);

        return $this;
    }

    public function orGroup(self $group): self
    {
        $this->blocks[] = 'OR';
        $this->blocks[] = $group;

        $group->setParent($this);

        return $this;
    }

    public function setParent(self $parent): void
    {
        $this->parent = $parent;
    }

    public function build(): string
    {
        $blocks = array_map(
            static function ($block) {
                if ($block instanceof BuildableInterface) {
                    return $block->build();
                }

                return (string) $block;
            },
            $this->blocks
        );

        if (null !== $this->parent) {
            return '('.implode(' ', $blocks).')';
        }

        return implode(' ', $blocks);
    }
}
