<?php

namespace Terminal42\WeblingApi\Entity;

class Documentgroup extends AbstractEntity
{
    /**
     * {@inheritdoc}
     */
    public function getType()
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
