<?php

namespace Terminal42\WeblingApi\Query;

class Parameter implements BuildableInterface
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
     * @param string     $property
     * @param Query|null $parent
     */
    public function __construct($property, Query $parent = null)
    {
        $this->property = $property;
        $this->parent = $parent;
    }

    /**
     * Queries if property is *less than* given value.
     *
     * @param string|Parameter $value
     *
     * @return Query
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    public function isLessThan($value)
    {
        $this->setQuery('%s < %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *less than or equal to* given value.
     *
     * @param string|Parameter $value
     *
     * @return Query
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    public function isLessOrEqualThan($value)
    {
        $this->setQuery('%s <= %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *greater than* given value.
     *
     * @param string|Parameter $value
     *
     * @return Query
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    public function isGreaterThan($value)
    {
        $this->setQuery('%s > %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *greater than or equal to* given value.
     *
     * @param string|Parameter $value
     *
     * @return Query
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    public function isGreaterOrEqualThan($value)
    {
        $this->setQuery('%s >= %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *equal to* given value.
     *
     * @param string|Parameter $value
     *
     * @return Query
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    public function isEqualTo($value)
    {
        $this->setQuery('%s = %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *not equal to* given value.
     *
     * @param string|Parameter $value
     *
     * @return Query
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    public function isNotEqualTo($value)
    {
        $this->setQuery('%s != %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *equals* to given value.
     * Placeholders * (many characters) and ? (one character) are allowed.
     *
     * @param string $value
     *
     * @return Query
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    public function like($value)
    {
        $this->setQuery('%s LIKE %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *not equals* to given value.
     * Placeholders * (many characters) and ? (one character) are allowed.
     *
     * @param string|Parameter $value
     *
     * @return Query
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    public function notLike($value)
    {
        $this->setQuery('%s NOT LIKE %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *empty*.
     *
     * @return Query
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    public function isEmpty()
    {
        $this->setQuery('%s IS EMPTY', null);

        return $this->parent;
    }

    /**
     * Queries if property is *not empty*.
     *
     * @return Query
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    public function isNotEmpty()
    {
        $this->setQuery('%s IS NOT EMPTY', null);

        return $this->parent;
    }

    /**
     * Queries if property value is *one of given options*.
     *
     * @param string[] $values
     *
     * @return Query
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    public function in(array $values)
    {
        $this->setQuery('%s IN (%s)', $values);

        return $this->parent;
    }

    /**
     * Queries if property value is *not one of given options*.
     *
     * @param string[] $values
     *
     * @return Query
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    public function notIn(array $values)
    {
        $this->setQuery('%s NOT IN (%s)', $values);

        return $this->parent;
    }

    /**
     * Queries if property *contains* given value.
     *
     * @param string $value
     *
     * @return Query
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    public function filter($value)
    {
        $this->setQuery('%s FILTER %s', $value);

        return $this->parent;
    }

    /**
     * Returns the property name.
     *
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Gets the parent query.
     *
     * @return Query|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets the parent query.
     *
     * @param Query $parent
     */
    public function setParent(Query $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Returns query string for property condition.
     *
     * @return string
     *
     * @throws \RuntimeException If the parameter does not have a query condition.
     */
    public function build()
    {
        if (empty($this->query)) {
            throw new \RuntimeException(sprintf('Missing query condition for property "%s"', $this->property));
        }

        return (string) $this->query;
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
     * @param string $operation
     * @param mixed  $value
     *
     * @throws \RuntimeException If a query condition has already been configured on this parameter.
     */
    private function setQuery($operation, $value)
    {
        if (null !== $this->query) {
            throw new \RuntimeException(
                sprintf('Query condition for property "%s" has already been set.', $this->property)
            );
        }

        $this->query = sprintf(
            $operation,
            $this->escapeProperty($this->property),
            $this->escapeValue($value)
        );
    }

    /**
     * Escapes property name if it contains special characters.
     *
     * @param string $name
     *
     * @return string
     */
    private function escapeProperty($name)
    {
        return preg_match('/^[a-z0-9,\*]+$/i', $name) ? $name : sprintf('`%s`', $name);
    }

    /**
     * Escapes parameter value.
     *
     * @param mixed $value
     *
     * @return string
     */
    private function escapeValue($value)
    {
        if ($value instanceof Parameter) {
            return $this->escapeProperty($value->getProperty());
        }

        return '"' . (is_array($value) ? implode('", "', $value) : $value) . '"';
    }
}
