<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Entity;

use Terminal42\WeblingApi\EntityList;

interface EntityInterface extends \JsonSerializable
{
    /**
     * Gets the entity type.
     */
    public static function getType(): string;

    /**
     * Gets the parent entity type.
     */
    public static function getParentType(): ?string;

    /**
     * Return whether the entity is read-only.
     */
    public function isReadonly(): bool;

    /**
     * Gets the entity ID.
     */
    public function getId(): ?int;

    /**
     * Sets the entity ID.
     */
    public function setId(int $id): self;

    /**
     * Unsets the entity ID.
     */
    public function unsetId(): self;

    /**
     * Gets all entity properties.
     */
    public function getProperties(): array;

    /**
     * Sets all entity properties.
     */
    public function setProperties(array $properties): self;

    /**
     * Gets an entity property by name.
     *
     * @return mixed
     */
    public function getProperty(string $name);

    /**
     * Sets a entity property by name.
     *
     * @param mixed $value
     */
    public function setProperty(string $name, $value): self;

    /**
     * Gets the entity children.
     */
    public function getChildren(string $type): ?EntityList;

    /**
     * Gets the entity parents.
     */
    public function getParents(): ?EntityList;

    /**
     * Sets the entity parents.
     */
    public function setParents(EntityList $parents): self;

    /**
     * Gets the linked entities.
     */
    public function getLinks(string $type): ?EntityList;
}
