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
        $this->setQuery('%s < %s', $value);

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function isLessOrEqualThan($value)
    {
        $this->setQuery('%s <= %s', $value);

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function isGreaterThan($value)
    {
        $this->setQuery('%s > %s', $value);

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function isGreaterOrEqualThan($value)
    {
        $this->setQuery('%s >= %s', $value);

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function isEqualTo($value)
    {
        $this->setQuery('%s = %s', $value);

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function isNotEqualTo($value)
    {
        $this->setQuery('%s != %s', $value);

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function like($value)
    {
        $this->setQuery('%s LIKE %s', $value);

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function notLike($value)
    {
        $this->setQuery('%s NOT LIKE %s', $value);

        return $this->parent;
    }

    /**
     * @return Query
     */
    public function isEmpty()
    {
        $this->query = sprintf(
            '%s IS EMPTY',
            $this->quoteProperty($this->property)
        );

        return $this->parent;
    }

    /**
     * @return Query
     */
    public function isNotEmpty()
    {
        $this->query = sprintf(
            '%s IS NOT EMPTY',
            $this->quoteProperty($this->property)
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
        $this->setQuery('%s IN (%s)', $values);

        return $this->parent;
    }

    /**
     * @param string[] $values
     *
     * @return Query
     */
    public function notIn(array $values)
    {
        $this->setQuery('%s NOT IN (%s)', $values);

        return $this->parent;
    }

    /**
     * @param string $value
     *
     * @return Query
     */
    public function filter($value)
    {
        $this->setQuery('%s FILTER %s', $value);

        return $this->parent;
    }

    /**
     * @param Query $parent
     */
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

    /**
     * Builds the query string based on the given operation.
     *
     * @param string       $operation
     * @param string|array $value
     */
    private function setQuery($operation, $value)
    {
        $value = '"' . (is_array($value) ? implode('", "', $value) : $value) . '"';

        $this->query = sprintf(
            $operation,
            $this->quoteProperty($this->property),
            $value
        );
    }

    /**
     * Add quotes to string if it contains special characters.
     *
     * @param string $value
     *
     * @return string
     */
    private function quoteProperty($value)
    {
        return preg_match('/^[a-z0-9,\*]+$/i', $value) ? $value : sprintf('"%s"', $value);
    }
}
