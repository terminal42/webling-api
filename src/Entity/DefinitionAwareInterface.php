<?php

namespace Terminal42\WeblingApi\Entity;

interface DefinitionAwareInterface
{
    /**
     * Sets the definition for an entity.
     *
     * @param array $definition
     */
    public function setDefinition(array $definition);
}
