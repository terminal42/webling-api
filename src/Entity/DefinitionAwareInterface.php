<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Entity;

interface DefinitionAwareInterface
{
    /**
     * Sets the definition for an entity.
     */
    public function setDefinition(array $definition);
}
