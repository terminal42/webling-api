<?php

namespace Terminal42\WeblingApi\Entity;

class Document extends AbstractEntity
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'document';
    }

    /**
     * Get the content of the file.
     *
     * @internal not yet implemented
     */
    public function getContent()
    {
        // TODO: implement method
    }
}
