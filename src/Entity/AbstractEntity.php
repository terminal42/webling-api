<?php

namespace Terminal42\WeblingApi\Entity;

use Terminal42\WeblingApi\EntityList;

abstract class AbstractEntity implements EntityInterface
{
    protected $id;
    protected $readonly;
    protected $properties;
    protected $children;
    protected $parents;
    protected $links;

    public function __construct(
        $id = null,
        $readonly = false,
        array $properties = [],
        array $children = [],
        EntityList $parents = null,
        EntityList $links = null
    ) {
        $this->id         = $id;
        $this->readonly   = (bool) $readonly;
        $this->properties = $properties;
        $this->children   = $children;
        $this->parents    = $parents;
        $this->links      = $links;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * {@inheritdoc}
     */
    public function unsetId()
    {
        $this->id = null;
    }


    /**
     * {@inheritdoc}
     */
    public function isReadonly()
    {
        return $this->readonly;
    }

    /**
     * {@inheritdoc}
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * {@inheritdoc}
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
    }

    /**
     * {@inheritdoc}
     */
    public function getProperty($name)
    {
        return $this->properties[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function setProperty($name, $value)
    {
        $this->properties[$name] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren($type)
    {
        if (!isset($this->children[$type])) {
            return null;
        }

        return $this->children[$type];
    }

    /**
     * {@inheritdoc}
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * {@inheritdoc}
     */
    public function setParents(EntityList $parents)
    {
        $this->parents = $parents;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * {@inheritdoc}
     */
    public function setLinks(EntityList $links)
    {
        $this->links = $links;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        $data = [
            'type'       => $this->getType(),
            'readonly'   => (int) $this->isReadonly(),
            'properties' => array_map(
                function($v) {
                    return (null === $v || is_scalar($v)) ? $v : (string) $v;
                },
                $this->getProperties()
            ),
            'parents'    => $this->getParents() ? $this->getParents()->getIds() : [],
            'links'      => $this->getLinks() ? $this->getLinks()->getIds() : []
        ];

        return json_encode($data);
    }
}
