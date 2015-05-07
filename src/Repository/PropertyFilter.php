<?php

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\Entity\EntityInterface;
use Terminal42\WeblingApi\EntityList;

/**
 * PropertyFilter filters an EntityList by properties.
 *
 * @method EntityInterface current()
 */
class PropertyFilter extends \FilterIterator
{
    /**
     * @var array
     */
    private $properties;

    /**
     * Constructor.
     *
     * @param EntityList $iterator
     * @param array      $properties An array where keys are property names
     */
    public function __construct(EntityList $iterator, array $properties)
    {
        parent::__construct($iterator);

        $this->properties = $properties;
    }

    /**
     * {@inheritdoc}
     */
    public function accept()
    {
        $entity = $this->current();

        foreach ($this->properties as $name => $value) {
            if (strpos($entity->getProperty($name), $value) === false) {
                return false;
            }
        }

        return true;
    }
}
