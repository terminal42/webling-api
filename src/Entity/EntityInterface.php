<?php

namespace Terminal42\WeblingApi\Entity;

use Terminal42\WeblingApi\EntityList;

interface EntityInterface
{
    /**
     * Gets the entity type.
     *
     * @return string
     */
    public function getType();

    /**
     * Return whether the entity is read-only.
     *
     * @return bool
     */
    public function isReadonly();

    /**
     * Gets the entity ID.
     *
     * @return int
     */
    public function getId();

    /**
     * Sets the entity ID.
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id);

    /**
     * Unsets the entity ID.
     *
     * @return $this
     */
    public function unsetId();

    /**
     * Gets all entity properties.
     *
     * @return array
     */
    public function getProperties();

    /**
     * Sets all entity properties
     *
     * @param array $properties
     *
     * @return $this
     */
    public function setProperties(array $properties);

    /**
     * Gets an entity property by name.
     *
     * @param string $name The property name
     *
     * @return mixed
     */
    public function getProperty($name);

    /**
     * Sets a entity property by name.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function setProperty($name, $value);

    /**
     * Gets the entity children.
     *
     * @param string $type An entity type.
     *
     * @return EntityList|null
     */
    public function getChildren($type);

    /**
     * Gets the entity parents.
     *
     * @return EntityList|null
     */
    public function getParents();

    /**
     * Sets the entity parents.
     *
     * @param EntityList $parents
     *
     * @return $this
     */
    public function setParents(EntityList $parents);

    /**
     * Gets the linked entities.
     *
     * @return EntityList|null
     */
    public function getLinks();

    /**
     * Sets the linked entities.
     *
     * @param EntityList $links
     *
     * @return $this
     */
    public function setLinks(EntityList $links);

    /**
     * Returns a JSON representation of the entity.
     *
     * @return string
     */
    public function serialize();
}
