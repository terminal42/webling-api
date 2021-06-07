<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Entity;

class Documentgroup extends AbstractEntity
{
    public static function getType(): string
    {
        return 'documentgroup';
    }

    public static function getParentType(): string
    {
        return 'documentgroup';
    }

    /**
     * Get a zip archive of all documents and sub documentgroups.
     *
     * @internal not yet implemented
     */
    public function getArchive()
    {
        // TODO: implement method
    }
}
