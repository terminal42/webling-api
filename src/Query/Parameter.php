<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Query;

class Parameter implements BuildableInterface
{
    /**
     * @var string
     */
    private $property;

    /**
     * @var bool
     */
    private $not = false;

    /**
     * @var string
     */
    private $query;

    /**
     * @var Query
     */
    private $parent;

    public function __construct(string $property, Query $parent = null)
    {
        $this->property = $property;
        $this->parent = $parent;
    }

    public function __toString(): string
    {
        return $this->query;
    }

    /**
     * Inverses the query to find what does NOT match
     */
    public function not(): self
    {
        $this->not = true;

        return $this;
    }

    /**
     * Queries if property is *less than* given value.
     *
     * @param string|Parameter $value
     *
     * @throws \RuntimeException if a query condition has already been configured on this parameter
     */
    public function isLessThan($value): ?Query
    {
        $this->setQuery('%s < %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *less than or equal to* given value.
     *
     * @param string|Parameter $value
     *
     * @throws \RuntimeException if a query condition has already been configured on this parameter
     */
    public function isLessOrEqualThan($value): ?Query
    {
        $this->setQuery('%s <= %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *greater than* given value.
     *
     * @param string|Parameter $value
     *
     * @throws \RuntimeException if a query condition has already been configured on this parameter
     */
    public function isGreaterThan($value): ?Query
    {
        $this->setQuery('%s > %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *greater than or equal to* given value.
     *
     * @param string|Parameter $value
     *
     * @throws \RuntimeException if a query condition has already been configured on this parameter
     */
    public function isGreaterOrEqualThan($value): ?Query
    {
        $this->setQuery('%s >= %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *equal to* given value.
     *
     * @param string|Parameter $value
     *
     * @throws \RuntimeException if a query condition has already been configured on this parameter
     */
    public function isEqualTo($value): ?Query
    {
        $this->setQuery('%s = %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *not equal to* given value.
     *
     * @param string|Parameter $value
     *
     * @throws \RuntimeException if a query condition has already been configured on this parameter
     */
    public function isNotEqualTo($value): ?Query
    {
        $this->setQuery('%s != %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property is *empty*.
     *
     * @throws \RuntimeException if a query condition has already been configured on this parameter
     */
    public function isEmpty(): ?Query
    {
        $this->setQuery('%s IS EMPTY', null);

        return $this->parent;
    }

    /**
     * Queries if property value is *one of given options*.
     *
     * @param array<string> $values
     *
     * @throws \RuntimeException if a query condition has already been configured on this parameter
     */
    public function in(array $values): ?Query
    {
        $this->setQuery('%s IN (%s)', $values);

        return $this->parent;
    }

    /**
     * Queries if property *starts with* given value.
     *
     * @param string $value
     *
     * @throws \RuntimeException if a query condition has already been configured on this parameter
     */
    public function filter($value): ?Query
    {
        $this->setQuery('%s FILTER %s', $value);

        return $this->parent;
    }

    /**
     * Queries if property *contains* given value.
     *
     * @param string $value
     *
     * @throws \RuntimeException if a query condition has already been configured on this parameter
     */
    public function contains($value): ?Query
    {
        $this->setQuery('%s CONTAINS %s', $value);

        return $this->parent;
    }

    /**
     * Returns the property name.
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * Gets the parent query.
     */
    public function getParent(): ?Query
    {
        return $this->parent;
    }

    /**
     * Sets the parent query.
     */
    public function setParent(Query $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * Returns query string for property condition.
     *
     * @throws \RuntimeException if the parameter does not have a query condition
     */
    public function build(): string
    {
        if (empty($this->query)) {
            throw new \RuntimeException(sprintf('Missing query condition for property "%s"', $this->property));
        }

        return $this->query;
    }

    /**
     * Builds the query string based on the given operation.
     *
     * @param mixed $value
     *
     * @throws \RuntimeException if a query condition has already been configured on this parameter
     */
    private function setQuery(string $operation, $value): void
    {
        if (null !== $this->query) {
            throw new \RuntimeException(sprintf('Query condition for property "%s" has already been set.', $this->property));
        }

        $this->query = sprintf(
            $operation,
            $this->escapeProperty($this->property),
            $this->escapeValue($value)
        );

        if  ($this->not) {
            $this->query = 'NOT ('.$this->query.')';
        }
    }

    /**
     * Escapes property name if it contains special characters.
     */
    private function escapeProperty(string $name): string
    {
        return preg_match('/^[a-z0-9,*]+$/i', $name) ? $name : sprintf('`%s`', $name);
    }

    /**
     * Escapes parameter value.
     *
     * @param mixed $value
     */
    private function escapeValue($value): string
    {
        if ($value instanceof self) {
            return $this->escapeProperty($value->getProperty());
        }

        return '"'.(\is_array($value) ? implode('", "', $value) : $value).'"';
    }
}
