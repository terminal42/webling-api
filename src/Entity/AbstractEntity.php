<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Entity;

use Terminal42\WeblingApi\EntityList;

abstract class AbstractEntity implements EntityInterface
{
    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var bool
     */
    protected $readonly;

    /**
     * @var array
     */
    protected $properties;

    /**
     * @var array
     */
    protected $children;

    /**
     * @var EntityList|null
     */
    protected $parents;

    /**
     * @var EntityList|null
     */
    protected $links;

    public function __construct(int $id = null, bool $readonly = false, array $properties = [], array $children = [], EntityList $parents = null, array $links = [])
    {
        $this->id = $id;
        $this->readonly = (bool) $readonly;
        $this->properties = $properties;
        $this->children = $children;
        $this->parents = $parents;
        $this->links = $links;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): EntityInterface
    {
        $this->id = $id;

        return $this;
    }

    public function unsetId(): EntityInterface
    {
        $this->id = null;

        return $this;
    }

    public function isReadonly(): bool
    {
        return $this->readonly;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function setProperties(array $properties): EntityInterface
    {
        $this->properties = $properties;

        return $this;
    }

    public function getProperty(string $name)
    {
        return $this->properties[$name];
    }

    public function setProperty(string $name, $value): EntityInterface
    {
        $this->properties[$name] = $value;

        return $this;
    }

    public function getChildren(string $type): ?EntityList
    {
        return $this->children[$type] ?? null;
    }

    public function getParents(): ?EntityList
    {
        return $this->parents;
    }

    public function setParents(EntityList $parents): EntityInterface
    {
        $this->parents = $parents;

        return $this;
    }

    public function getLinks(string $type): ?EntityList
    {
        return $this->links[$type] ?? null;
    }

    public function jsonSerialize()
    {
        $data = [
            'type' => $this->getType(),
            'readonly' => (int) $this->readonly,
            'properties' => $this->properties,
            'children' => $this->children,
            'parents' => $this->parents,
            'links' => $this->links,
        ];

        return json_encode($data);
    }
}
