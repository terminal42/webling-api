<?php

namespace Terminal42\WeblingApi\Query;

class Parameter
{
    /**
     * @var string
     */
    private $property;

    /**
     * @var string
     */
    private $query;

    /**
     * @var Query
     */
    private $parent;

    /**
     * Constructor.
     *
     * @param string $property
     */
    public function __construct($property)
    {
        $this->property = $property;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function isLessThan($value)
    {
        $this->validate();

        $this->query = sprintf(
            '%s < %s',
            $this->property,
            $value
        );

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function isLessOrEqualThan($value)
    {
        $this->validate();

        $this->query = sprintf(
            '%s <= %s',
            $this->property,
            $value
        );

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function isGreaterThan($value)
    {
        $this->validate();

        $this->query = sprintf(
            '%s > %s',
            $this->property,
            $value
        );

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function isGreaterOrEqualThan($value)
    {
        $this->validate();

        $this->query = sprintf(
            '%s >= %s',
            $this->property,
            $value
        );

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function isEqualTo($value)
    {
        $this->validate();

        $this->query = sprintf(
            '%s = "%s"',
            $this->property,
            $value
        );

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function isNotEqualTo($value)
    {
        $this->validate();

        $this->query = sprintf(
            '%s != "%s"',
            $this->property,
            $value
        );

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function like($value)
    {
        $this->validate();

        $this->query = sprintf(
            '%s LIKE "%s"',
            $this->property,
            $value
        );

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function notLike($value)
    {
        $this->validate();

        $this->query = sprintf(
            '%s NOT LIKE "%s"',
            $this->property,
            $value
        );

        return $this->parent;
    }

    /**
     * @return Query
     */
    public function isEmpty()
    {
        $this->validate();

        $this->query = sprintf(
            '%s IS EMPTY',
            $this->property
        );

        return $this->parent;
    }

    /**
     * @return Query
     */
    public function isNotEmpty()
    {
        $this->validate();

        $this->query = sprintf(
            '%s IS NOT EMPTY',
            $this->property
        );

        return $this->parent;
    }

    /**
     * @param string[] $values
     *
     * @return Query
     */
    public function in(array $values)
    {
        $this->validate();

        $this->query = sprintf(
            '%s IN ("%s")',
            $this->property,
            implode('", "', $values)
        );

        return $this->parent;
    }

    /**
     * @param string[] $values
     *
     * @return Query
     */
    public function notIn(array $values)
    {
        $this->validate();

        $this->query = sprintf(
            '%s NOT IN ("%s")',
            $this->property,
            implode('", "', $values)
        );

        return $this->parent;
    }

    public function setParent(Query $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->query;
    }

    private function validate()
    {
        if (null !== $this->query) {
            throw new \BadMethodCallException('Query parameter already configured.');
        }
    }
}
